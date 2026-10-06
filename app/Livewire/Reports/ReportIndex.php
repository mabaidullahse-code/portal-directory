<?php

namespace App\Livewire\Reports;

use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use App\Services\PortalReportService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReportIndex extends Component
{
    public string $departmentId = 'all';
    public string $userId = 'all';
    public string $categoryId = 'all';
    public string $status = 'all';
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    public function mount(): void
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $user->department_id) {
            $this->departmentId = (string) $user->department_id;
        }
    }

    public function downloadPdf(PortalReportService $reportService): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $user = Auth::user();
        $filters = $this->buildFilters();

        $pdf = $reportService->generatePdf($user, $filters);
        $fileName = 'portal_directory_report_' . now()->format('Y_m_d_His') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function downloadHtml(PortalReportService $reportService): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $user = Auth::user();
        $filters = $this->buildFilters();

        $htmlContent = $reportService->generateStandaloneHtml($user, $filters);
        $fileName = 'portal_directory_report_' . now()->format('Y_m_d_His') . '.html';

        return response()->streamDownload(function () use ($htmlContent) {
            echo $htmlContent;
        }, $fileName, [
            'Content-Type' => 'text/html',
        ]);
    }

    protected function buildFilters(): array
    {
        $user = Auth::user();
        $deptId = null;

        if (!$user->isAdmin()) {
            $deptId = $user->department_id;
        } elseif ($this->departmentId !== 'all') {
            $deptId = (int) $this->departmentId;
        }

        return [
            'department_id' => $deptId,
            'user_id' => $this->userId !== 'all' ? (int) $this->userId : null,
            'category_id' => $this->categoryId !== 'all' ? (int) $this->categoryId : null,
            'status' => $this->status,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
        ];
    }

    public function render(PortalReportService $reportService)
    {
        $user = Auth::user();
        $filters = $this->buildFilters();

        // Get report structured data for live on-screen table preview
        $reportData = $reportService->prepareReportData($user, $filters);

        // Departments dropdown
        $departments = $user->isAdmin()
            ? Department::active()->orderBy('name')->get()
            : Department::where('id', $user->department_id)->get();

        // Employees dropdown (dependent on department)
        $employeesQuery = User::active()->orderBy('name');
        if (!empty($filters['department_id'])) {
            $employeesQuery->where('department_id', $filters['department_id']);
        } elseif (!$user->isAdmin() && $user->department_id) {
            $employeesQuery->where('department_id', $user->department_id);
        }
        $availableEmployees = $employeesQuery->get();

        $categories = Category::active()->ordered()->get();

        return view('livewire.reports.report-index', [
            'reportData' => $reportData,
            'departments' => $departments,
            'availableEmployees' => $availableEmployees,
            'categories' => $categories,
            'user' => $user,
        ])->layout('layouts.app', ['title' => 'Portal Reports & Exports']);
    }
}
