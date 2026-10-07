<?php

namespace App\Filament\Pages;

use App\Enums\PortalDisplayDesign;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\PortalVisibilityService;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class DirectoryDesignSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static string|\UnitEnum|null $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Directory Design';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Portal Directory Architectural Design Settings';

    protected string $view = 'filament.pages.directory-design-settings';

    public string $currentSavedDesign = 'card_grid';

    public string $selectedPreviewDesign = 'card_grid';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->currentSavedDesign = Setting::get('portal_directory_design', PortalDisplayDesign::CARD_GRID->value);
        $this->selectedPreviewDesign = $this->currentSavedDesign;
    }

    public function selectDesign(string $designKey): void
    {
        if (PortalDisplayDesign::tryFrom($designKey)) {
            $this->selectedPreviewDesign = $designKey;
        }
    }

    public function saveDefaultDesign(): void
    {
        Setting::set('portal_directory_design', $this->selectedPreviewDesign);
        $oldDesign = $this->currentSavedDesign;
        $this->currentSavedDesign = $this->selectedPreviewDesign;

        ActivityLog::record(
            'settings.design_updated',
            "Administrator changed default directory design to '{$this->selectedPreviewDesign}'",
            null,
            ['design' => $oldDesign],
            ['design' => $this->selectedPreviewDesign]
        );

        Notification::make()
            ->title('Design Configuration Saved')
            ->body("Default portal directory design successfully saved as '{$this->selectedPreviewDesign}'.")
            ->success()
            ->send();

        session()->flash('success', "Default portal directory design successfully saved as '{$this->selectedPreviewDesign}'.");
    }

    protected function getViewData(): array
    {
        $visibilityService = app(PortalVisibilityService::class);
        $user = Auth::user();
        $departments = $visibilityService->getDirectoryTree($user);
        $previewDesignInstance = PortalDisplayDesign::tryFrom($this->selectedPreviewDesign) ?? PortalDisplayDesign::CARD_GRID;

        return [
            'designs' => PortalDisplayDesign::cases(),
            'departments' => $departments,
            'sampleDepartments' => $departments,
            'previewDesignInstance' => $previewDesignInstance,
        ];
    }
}
