<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DepartmentImportService
{
    /**
     * Parse an uploaded spreadsheet/CSV file and validate rows for preview.
     *
     * @return array{headers: array, rows: array, valid_count: int, invalid_count: int}
     */
    public function parseAndValidate(string $filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rawRows = $worksheet->toArray(null, true, true, true);

        if (empty($rawRows)) {
            return [
                'headers' => [],
                'rows' => [],
                'valid_count' => 0,
                'invalid_count' => 0,
            ];
        }

        // Normalize header row
        $firstRow = array_shift($rawRows);
        $headers = [];
        $headerMap = [];

        foreach ($firstRow as $colKey => $colValue) {
            $normalized = strtolower(trim((string)$colValue));
            $normalized = str_replace([' ', '-', '/'], '_', $normalized);
            if (!empty($normalized)) {
                $headers[$colKey] = $normalized;
                $headerMap[$normalized] = $colKey;
            }
        }

        $parsedRows = [];
        $existingNames = Department::pluck('name')->map(fn($v) => strtolower(trim($v)))->toArray();
        $existingCodes = Department::pluck('code')->map(fn($v) => strtoupper(trim($v)))->toArray();

        $batchNames = [];
        $batchCodes = [];

        $rowIndex = 2; // Starting after header row
        $validCount = 0;
        $invalidCount = 0;

        foreach ($rawRows as $row) {
            // Check if entire row is empty
            $rowValues = array_filter(array_map('trim', array_values($row)));
            if (empty($rowValues)) {
                $rowIndex++;
                continue;
            }

            $name = trim((string)($row[$headerMap['name'] ?? 'A'] ?? ''));
            $shortName = trim((string)($row[$headerMap['short_name'] ?? 'B'] ?? ''));
            $code = strtoupper(trim((string)($row[$headerMap['code'] ?? 'C'] ?? '')));
            $description = trim((string)($row[$headerMap['description'] ?? 'D'] ?? ''));
            $status = strtolower(trim((string)($row[$headerMap['status'] ?? 'E'] ?? 'active')));

            if (!in_array($status, ['active', 'inactive'])) {
                $status = 'active';
            }

            $errors = [];

            if (empty($name)) {
                $errors[] = 'Department name is required.';
            } elseif (in_array(strtolower($name), $existingNames, true)) {
                $errors[] = "Department '{$name}' already exists in database.";
            } elseif (in_array(strtolower($name), $batchNames, true)) {
                $errors[] = "Duplicate department name '{$name}' in this import file.";
            }

            if (empty($code)) {
                $errors[] = 'Department code is required.';
            } elseif (in_array($code, $existingCodes, true)) {
                $errors[] = "Department code '{$code}' already exists in database.";
            } elseif (in_array($code, $batchCodes, true)) {
                $errors[] = "Duplicate department code '{$code}' in this import file.";
            }

            $isValid = empty($errors);
            if ($isValid) {
                $validCount++;
                $batchNames[] = strtolower($name);
                $batchCodes[] = $code;
            } else {
                $invalidCount++;
            }

            $parsedRows[] = [
                'row_number' => $rowIndex,
                'name' => $name,
                'short_name' => $shortName ?: $name,
                'code' => $code,
                'description' => $description,
                'status' => $status,
                'is_valid' => $isValid,
                'errors' => $errors,
            ];

            $rowIndex++;
        }

        return [
            'headers' => ['Name', 'Short Name', 'Code', 'Description', 'Status'],
            'rows' => $parsedRows,
            'valid_count' => $validCount,
            'invalid_count' => $invalidCount,
        ];
    }

    /**
     * Commit valid records to the database.
     *
     * @param array $rows
     * @return array{imported: int, skipped: int}
     */
    public function importValidRows(array $rows): array
    {
        $importedCount = 0;
        $skippedCount = 0;

        DB::transaction(function () use ($rows, &$importedCount, &$skippedCount) {
            foreach ($rows as $row) {
                if (empty($row['is_valid'])) {
                    $skippedCount++;
                    continue;
                }

                // Check again to be safe against concurrency
                $exists = Department::where('name', $row['name'])
                    ->orWhere('code', $row['code'])
                    ->exists();

                if ($exists) {
                    $skippedCount++;
                    continue;
                }

                $department = Department::create([
                    'name' => $row['name'],
                    'short_name' => $row['short_name'] ?? $row['name'],
                    'code' => $row['code'],
                    'description' => $row['description'] ?? null,
                    'status' => $row['status'] ?? 'active',
                ]);

                ActivityLog::record(
                    'department.imported',
                    "Imported department '{$department->name}' ({$department->code})",
                    $department,
                    null,
                    $department->toArray()
                );

                $importedCount++;
            }
        });

        return [
            'imported' => $importedCount,
            'skipped' => $skippedCount,
        ];
    }
}
