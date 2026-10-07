<?php

namespace App\Filament\Pages;

use App\Services\DepartmentImportService;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class DepartmentImport extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;

    protected static string|\UnitEnum|null $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Import Departments';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?int $navigationSort = 6;

    protected static ?string $title = 'Bulk Import Departments via Spreadsheet';

    protected string $view = 'filament.pages.department-import';

    public $file;

    public array $previewRows = [];

    public array $importResult = [];

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function downloadSampleCsv(DepartmentImportService $importService)
    {
        $csv = $importService->generateSampleCsv();

        return response()->streamDownload(
            fn () => print ($csv),
            'departments_sample_template.csv',
            ['Content-Type' => 'text/csv']
        );
    }

    public function processImport(DepartmentImportService $importService): void
    {
        $this->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:10240'],
        ]);

        $result = $importService->importFromFile($this->file->getRealPath());
        $this->importResult = $result;

        if ($result['imported'] > 0) {
            Notification::make()
                ->title('Import Successful')
                ->body("Successfully imported {$result['imported']} departments.")
                ->success()
                ->send();
        }

        if (! empty($result['errors'])) {
            Notification::make()
                ->title('Import Warning')
                ->body(count($result['errors']).' rows had errors and were skipped.')
                ->warning()
                ->send();
        }

        $this->reset('file');
    }
}
