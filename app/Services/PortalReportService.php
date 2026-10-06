<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class PortalReportService
{
    public function __construct(
        protected PortalVisibilityService $visibilityService
    ) {}

    /**
     * Prepare structured report data respecting user permissions.
     */
    public function prepareReportData(User $user, array $filters = []): array
    {
        $deptQuery = Department::query()->active()->orderBy('name');

        if (!$user->isAdmin()) {
            if ($user->department_id) {
                $deptQuery->where('id', $user->department_id);
            } else {
                $deptQuery->whereRaw('1 = 0');
            }
        } elseif (!empty($filters['department_id'])) {
            $deptQuery->where('id', $filters['department_id']);
        }

        $departments = $deptQuery->get();

        $portalQuery = Portal::query()
            ->with(['user', 'department', 'category', 'targetDepartments'])
            ->orderBy('sort_order')
            ->orderBy('title');

        $this->visibilityService->applyVisibleScope($portalQuery, $user);

        // Apply filters
        if (!empty($filters['department_id'])) {
            $portalQuery->where('department_id', $filters['department_id']);
        }

        if (!empty($filters['user_id'])) {
            $portalQuery->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $portalQuery->where('status', $filters['status']);
        }

        if (!empty($filters['category_id'])) {
            $portalQuery->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['date_from'])) {
            $portalQuery->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $portalQuery->whereDate('created_at', '<=', $filters['date_to']);
        }

        $portals = $portalQuery->get();

        // Group by department then by employee
        $groupedData = [];
        $totalPortals = $portals->count();
        $activePortals = $portals->where('status.value', 'active')->count();
        $inactivePortals = $totalPortals - $activePortals;

        foreach ($portals->groupBy('department_id') as $deptId => $deptPortals) {
            $deptModel = $departments->firstWhere('id', $deptId) ?? $deptPortals->first()->department;
            $deptEmployees = [];

            foreach ($deptPortals->groupBy('user_id') as $empId => $empPortals) {
                $employeeModel = $empPortals->first()->user;
                $deptEmployees[] = [
                    'employee' => $employeeModel,
                    'portals' => $empPortals,
                    'total' => $empPortals->count(),
                    'active' => $empPortals->where('status.value', 'active')->count(),
                    'inactive' => $empPortals->where('status.value', 'inactive')->count(),
                ];
            }

            $groupedData[] = [
                'department' => $deptModel,
                'employees' => $deptEmployees,
                'total_portals' => $deptPortals->count(),
                'active_portals' => $deptPortals->where('status.value', 'active')->count(),
                'inactive_portals' => $deptPortals->where('status.value', 'inactive')->count(),
            ];
        }

        $appliedDepartmentName = 'All Departments';
        if (!empty($filters['department_id'])) {
            $appliedDepartmentName = Department::find($filters['department_id'])?->name ?? 'All Departments';
        } elseif (!$user->isAdmin()) {
            $appliedDepartmentName = $user->department?->name ?? 'Department';
        }

        return [
            'title' => 'Portal Directory Report',
            'generated_at' => now(),
            'generated_by' => $user,
            'organization_name' => config('app.name', 'Organization Portal Directory'),
            'department_scope' => $appliedDepartmentName,
            'filters' => $filters,
            'departments' => $groupedData,
            'summary' => [
                'total_portals' => $totalPortals,
                'active_portals' => $activePortals,
                'inactive_portals' => $inactivePortals,
                'total_departments' => count($groupedData),
                'total_employees' => $portals->pluck('user_id')->unique()->count(),
            ],
        ];
    }

    /**
     * Generate PDF binary stream or download.
     */
    public function generatePdf(User $user, array $filters = []): \Barryvdh\DomPDF\PDF
    {
        $data = $this->prepareReportData($user, $filters);
        $pdf = Pdf::loadView('reports.portals-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);

        return $pdf;
    }

    /**
     * Generate standalone self-contained HTML report.
     */
    public function generateStandaloneHtml(User $user, array $filters = []): string
    {
        $data = $this->prepareReportData($user, $filters);
        return View::make('reports.portals-html', $data)->render();
    }
}
