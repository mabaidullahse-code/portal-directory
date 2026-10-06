<?php

namespace App\Livewire\Portal;

use App\Enums\PortalDisplayDesign;
use App\Models\Department;
use App\Models\Setting;
use App\Services\PortalVisibilityService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PortalDirectory extends Component
{
    public string $design = 'card_grid';
    public ?int $selectedDepartmentId = null;
    public string $search = '';
    public string $viewMode = 'visual'; // visual or table

    public function mount(): void
    {
        $this->design = Setting::get('portal_directory_design', PortalDisplayDesign::CARD_GRID->value);

        $user = Auth::user();
        if ($user && !$user->isAdmin()) {
            $this->selectedDepartmentId = $user->department_id;
        }
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

    public function selectDepartment(?int $deptId): void
    {
        $user = Auth::user();
        if ($user && !$user->isAdmin() && $deptId !== $user->department_id) {
            // Non-admins are locked to their own department
            return;
        }

        $this->selectedDepartmentId = $deptId;
    }

    public function render(PortalVisibilityService $visibilityService)
    {
        $user = Auth::user() ?? new \App\Models\User(['role' => \App\Enums\UserRole::ADMIN]); // fallback if public view
        $departments = $visibilityService->getDirectoryTree(
            $user,
            $this->selectedDepartmentId,
            $this->search
        );

        $allDepartments = Department::active()->orderBy('name')->get();

        return view('livewire.portal.portal-directory', [
            'departments' => $departments,
            'allDepartments' => $allDepartments,
            'designs' => PortalDisplayDesign::cases(),
        ])->layout('layouts.app', ['title' => 'Organizational Portal Directory']);
    }
}
