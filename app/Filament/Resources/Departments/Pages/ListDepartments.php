<?php

namespace App\Filament\Resources\Departments\Pages;

use App\Filament\Resources\Departments\DepartmentResource;
use App\Services\DepartmentImportService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importSpreadsheet')
                ->label('Import via Spreadsheet')
                ->icon(Heroicon::OutlinedArrowUpTray)
                ->color('success')
                ->modalHeading('Import Departments from Spreadsheet / CSV')
                ->modalDescription('Upload an Excel (.xlsx, .xls) or CSV file with department columns: name, short_name, code, description, status.')
                ->modalIcon(Heroicon::OutlinedDocumentArrowUp)
                ->modalWidth('lg')
                ->form([
                    FileUpload::make('spreadsheet')
                        ->label('Select Spreadsheet or CSV File')
                        ->acceptedFileTypes([
                            'text/csv',
                            'text/plain',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->disk('local')
                        ->directory('temp-department-imports')
                        ->required()
                        ->storeFiles()
                        ->helperText('Supported formats: .xlsx, .xls, .csv. First row must contain column headers.'),
                ])
                ->modalSubmitActionLabel('Import Now')
                ->action(function (array $data, DepartmentImportService $service) {
                    $filePath = Storage::disk('local')->path($data['spreadsheet']);
                    $result = $service->importFromFile($filePath);

                    // Clean up temp file
                    @unlink($filePath);

                    if (($result['imported'] ?? 0) > 0) {
                        Notification::make()
                            ->title('Departments Imported Successfully')
                            ->body("Successfully created {$result['imported']} departments. ".(! empty($result['errors']) ? count($result['errors']).' skipped.' : ''))
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Import Completed')
                            ->body('No new departments imported. '.(! empty($result['errors']) ? implode(', ', array_slice($result['errors'], 0, 3)) : 'All records existed or were skipped.'))
                            ->warning()
                            ->send();
                    }
                })
                ->extraModalFooterActions([
                    Action::make('downloadSample')
                        ->label('Download Sample Template CSV')
                        ->icon(Heroicon::OutlinedArrowDownTray)
                        ->color('gray')
                        ->action(function (DepartmentImportService $service) {
                            return response()->streamDownload(
                                fn () => print ($service->generateSampleCsv()),
                                'departments_sample_template.csv',
                                ['Content-Type' => 'text/csv']
                            );
                        }),
                ]),
            CreateAction::make(),
        ];
    }
}
