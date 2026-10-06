<?php

namespace App\Livewire\Admin\Departments;

use App\Services\DepartmentImportService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DepartmentImport extends Component
{
    use WithFileUploads;

    public $file;
    public array $parsedData = [];
    public bool $hasPreview = false;
    public ?array $importSummary = null;

    protected function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:10240'], // 10MB max
        ];
    }

    public function previewFile(DepartmentImportService $service): void
    {
        $this->validate();

        $path = $this->file->getRealPath();

        try {
            $this->parsedData = $service->parseAndValidate($path);
            $this->hasPreview = true;
            $this->importSummary = null;
        } catch (\Throwable $e) {
            $this->addError('file', 'Error parsing file: ' . $e->getMessage());
        }
    }

    public function commitImport(DepartmentImportService $service): void
    {
        if (empty($this->parsedData['rows'])) {
            session()->flash('error', 'No rows available for import.');
            return;
        }

        try {
            $result = $service->importValidRows($this->parsedData['rows']);
            $this->importSummary = $result;
            $this->hasPreview = false;
            $this->reset('file');

            session()->flash('success', "Import completed: {$result['imported']} departments successfully added.");
        } catch (\Throwable $e) {
            session()->flash('error', 'Failed during import commit: ' . $e->getMessage());
        }
    }

    public function downloadSampleCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $csvHeader = ['name', 'short_name', 'code', 'description', 'status'];
        $sampleRows = [
            ['Quality Enhancement Cell', 'QEC', 'QEC', 'Monitors educational standards and institutional accreditation.', 'active'],
            ['Planning & Development', 'P&D', 'PND', 'Infrastructure planning, PC-1 preparations, and civil projects.', 'active'],
            ['Student Financial Aid Office', 'Financial Aid', 'SFAO', 'Scholarships, fee waivers, and student welfare grants.', 'active'],
        ];

        return response()->streamDownload(function () use ($csvHeader, $sampleRows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $csvHeader);
            foreach ($sampleRows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 'departments_sample_import.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function resetUpload(): void
    {
        $this->reset(['file', 'parsedData', 'hasPreview', 'importSummary']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.departments.department-import')
            ->layout('layouts.app', ['title' => 'Import Departments']);
    }
}
