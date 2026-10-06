<?php

namespace App\Livewire\Admin\Settings;

use App\Enums\PortalDisplayDesign;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Setting;
use App\Services\PortalVisibilityService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DirectoryDesign extends Component
{
    public string $currentSavedDesign = 'card_grid';
    public string $selectedPreviewDesign = 'card_grid';

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

        session()->flash('success', "Default portal directory design successfully saved as '{$this->selectedPreviewDesign}'.");
    }

    public function render(PortalVisibilityService $visibilityService)
    {
        $user = Auth::user();
        $departments = $visibilityService->getDirectoryTree($user);

        return view('livewire.admin.settings.directory-design', [
            'designs' => PortalDisplayDesign::cases(),
            'departments' => $departments,
        ])->layout('layouts.app', ['title' => 'Portal Directory Design Settings']);
    }
}
