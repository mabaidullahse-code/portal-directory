<?php

namespace App\Livewire\Director;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Models\Portal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public ?int $selectedEmployeeId = null;

    public function selectEmployee(?int $empId): void
    {
        $this->selectedEmployeeId = $this->selectedEmployeeId === $empId ? null : $empId;
    }

    public function render()
    {
        $director = Auth::user();
        $department = $director->department;

        if (! $department) {
            abort(403, 'Director is not assigned to any department.');
        }

        $employeesCount = User::where('department_id', $department->id)
            ->where('role', UserRole::EMPLOYEE->value)
            ->count();

        $departmentPortalsQuery = Portal::where('department_id', $department->id);
        $totalPortals = (clone $departmentPortalsQuery)->count();
        $activePortals = (clone $departmentPortalsQuery)->where('status', PortalStatus::ACTIVE->value)->count();
        $inactivePortals = $totalPortals - $activePortals;

        // Employees with portal counts
        $employees = User::where('department_id', $department->id)
            ->where('role', UserRole::EMPLOYEE->value)
            ->with(['portals' => fn ($q) => $q->orderBy('sort_order')->orderBy('title')])
            ->withCount('portals')
            ->orderByDesc('portals_count')
            ->get();

        // Selected employee's portals if expanded
        $selectedEmployee = $this->selectedEmployeeId
            ? $employees->firstWhere('id', $this->selectedEmployeeId)
            : null;

        // Director's own portals
        $myPortals = Portal::where('user_id', $director->id)->get();

        return view('livewire.director.dashboard', [
            'department' => $department,
            'employeesCount' => $employeesCount,
            'totalPortals' => $totalPortals,
            'activePortals' => $activePortals,
            'inactivePortals' => $inactivePortals,
            'employees' => $employees,
            'selectedEmployee' => $selectedEmployee,
            'myPortals' => $myPortals,
        ])->layout('layouts.app', ['title' => "Director Dashboard - {$department->name}"]);
    }
}
