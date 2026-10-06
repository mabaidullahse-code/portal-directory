<?php

namespace App\Livewire\Admin;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalUsers = User::count();
        $totalEmployees = User::where('role', UserRole::EMPLOYEE->value)->count();
        $totalDirectors = User::where('role', UserRole::DIRECTOR->value)->count();
        $totalDepartments = Department::count();
        $totalPortals = Portal::count();
        $activePortals = Portal::where('status', PortalStatus::ACTIVE->value)->count();
        $inactivePortals = $totalPortals - $activePortals;

        // Portals by Department (for chart / metric breakdown)
        $departmentStats = Department::withCount('portals')
            ->orderByDesc('portals_count')
            ->take(6)
            ->get();

        // Portals by Category
        $categoryStats = Category::withCount('portals')
            ->orderByDesc('portals_count')
            ->take(6)
            ->get();

        // Top Employees by Portals
        $topEmployees = User::where('role', UserRole::EMPLOYEE->value)
            ->with('department')
            ->withCount('portals')
            ->orderByDesc('portals_count')
            ->take(5)
            ->get();

        // Recent Activity Logs
        $recentActivities = ActivityLog::with('user')
            ->latest('created_at')
            ->take(8)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalEmployees' => $totalEmployees,
            'totalDirectors' => $totalDirectors,
            'totalDepartments' => $totalDepartments,
            'totalPortals' => $totalPortals,
            'activePortals' => $activePortals,
            'inactivePortals' => $inactivePortals,
            'departmentStats' => $departmentStats,
            'categoryStats' => $categoryStats,
            'topEmployees' => $topEmployees,
            'recentActivities' => $recentActivities,
        ])->layout('layouts.app', ['title' => 'Admin Executive Dashboard']);
    }
}
