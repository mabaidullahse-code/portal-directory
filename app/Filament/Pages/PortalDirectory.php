<?php

namespace App\Filament\Pages;

use App\Enums\PortalDisplayDesign;
use App\Models\Setting;
use App\Services\PortalVisibilityService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class PortalDirectory extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'Directory & Access';

    protected static ?string $navigationLabel = 'Portal Directory';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Enterprise Portal Directory';

    protected string $view = 'filament.pages.portal-directory';

    public ?int $selectedDepartmentId = null;

    public string $search = '';

    public string $design = 'card_grid';

    public string $viewMode = 'visual';

    public function mount(): void
    {
        $this->design = Setting::get('portal_directory_design', PortalDisplayDesign::CARD_GRID->value);
    }

    public function selectDepartment(?int $departmentId): void
    {
        $this->selectedDepartmentId = $departmentId;
    }

    public function selectDesign(string $designKey): void
    {
        if (PortalDisplayDesign::tryFrom($designKey)) {
            $this->design = $designKey;
            $this->viewMode = 'visual';
        }
    }

    public function toggleViewMode(string $mode): void
    {
        $this->viewMode = $mode;
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->selectedDepartmentId = null;
    }

    protected function getViewData(): array
    {
        $visibilityService = app(PortalVisibilityService::class);
        $user = Auth::user();

        $departments = $visibilityService->getDirectoryTree(
            $user,
            $this->selectedDepartmentId,
            $this->search ?: null
        );

        $allDepartments = $visibilityService->getDirectoryTree(
            $user,
            null,
            null
        );

        return [
            'departments' => $departments,
            'allDepartments' => $allDepartments,
            'designs' => PortalDisplayDesign::cases(),
            'totalPortalsCount' => $departments->flatMap->users->flatMap->portals->count(),
        ];
    }
}
