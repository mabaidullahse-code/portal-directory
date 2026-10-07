<?php

namespace App\Livewire\Vc;

use App\Enums\PortalDisplayDesign;
use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Department;
use App\Models\Portal;
use App\Models\Setting;
use App\Models\User;
use App\Services\PortalReportService;
use App\Services\PortalVisibilityService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Dashboard extends Component
{
    public string $search = '';

    public string $departmentFilter = 'all';

    public string $categoryFilter = 'all';

    public string $layout = 'buttons'; // 'buttons', 'table', or any PortalDisplayDesign value

    public string $defaultDesign = 'buttons';

    public function mount(): void
    {
        $saved = Setting::get('portal_directory_design', 'buttons');
        $this->defaultDesign = $saved;
        if ($saved && (PortalDisplayDesign::tryFrom($saved) || in_array($saved, ['buttons', 'departments', 'categories', 'table']))) {
            $this->layout = $saved;
        }
    }

    public function downloadPdf(PortalReportService $reportService): StreamedResponse
    {
        $user = Auth::user();
        $pdf = $reportService->generatePdf($user);
        $fileName = 'portal_directory_report_'.now()->format('Y_m_d_His').'.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function downloadExcel(PortalReportService $reportService): StreamedResponse
    {
        $user = Auth::user();
        $spreadsheet = $reportService->generateSpreadsheet($user);
        $fileName = 'portal_directory_report_'.now()->format('Y_m_d_His').'.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function makeDefault(?string $layoutToSet = null): void
    {
        $target = $layoutToSet ?: $this->layout;
        Setting::set('portal_directory_design', $target);
        $this->defaultDesign = $target;
        $this->layout = $target;

        session()->flash('status', "Default view layout updated to '{$target}'.");
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->departmentFilter = 'all';
        $this->categoryFilter = 'all';
    }

    public function render()
    {
        // High-level organizational statistics for Vice Chancellor
        $totalPortals = Portal::where('status', PortalStatus::ACTIVE->value)->count();
        $totalDepartments = Department::where('status', 'active')->count();
        $totalEmployees = User::where('status', 'active')->count();
        $totalCategories = Category::count();

        // Portal query for link button grid
        $portalQuery = Portal::query()
            ->active()
            ->with(['department', 'category', 'user'])
            ->orderBy('sort_order')
            ->orderBy('title');

        if (! empty($this->search)) {
            $portalQuery->search($this->search);
        }

        if ($this->departmentFilter !== 'all') {
            if (str_starts_with($this->departmentFilter, 'target:')) {
                $targetName = substr($this->departmentFilter, 7);
                $portalQuery->where('target_department', $targetName);
            } else {
                $portalQuery->where('department_id', (int) $this->departmentFilter);
            }
        }

        if ($this->categoryFilter !== 'all') {
            $portalQuery->where('category_id', (int) $this->categoryFilter);
        }

        $portals = $portalQuery->get();

        $realDepartments = Department::active()
            ->whereHas('portals', fn ($q) => $q->active())
            ->orderBy('name')
            ->get();

        $targetDepartmentNames = Portal::active()
            ->whereNotNull('target_department')
            ->where('target_department', '!=', '')
            ->pluck('target_department')
            ->unique();

        $allDepartments = collect();
        foreach ($realDepartments as $rd) {
            $allDepartments->push((object) [
                'id' => (string) $rd->id,
                'name' => $rd->name,
                'code' => $rd->code,
            ]);
        }
        foreach ($targetDepartmentNames as $tName) {
            $code = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $tName), 0, 4)) ?: 'DEPT';
            $allDepartments->push((object) [
                'id' => 'target:'.$tName,
                'name' => $tName,
                'code' => $code,
            ]);
        }

        $departments = $portals->groupBy(function ($p) {
            return $p->target_department ?: ($p->department?->name ?? 'General & Universal Systems');
        })->map(function ($deptPortals, $deptName) {
            $first = $deptPortals->first();
            $code = $first->target_department
                ? (strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $first->target_department), 0, 4)) ?: 'TGT')
                : ($first->department?->code ?? 'UNIV');

            return (object) [
                'name' => $deptName,
                'code' => $code,
                'portals' => $deptPortals,
            ];
        });

        $categories = $portals->groupBy(function ($p) {
            return $p->category?->name ?? 'General & Uncategorized';
        })->map(function ($catPortals, $catName) {
            $first = $catPortals->first();
            $catModel = $first->category;
            $code = $catModel
                ? (strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $catModel->name), 0, 4)) ?: 'CAT')
                : 'GEN';
            $emoji = match ($catModel?->slug) {
                'hr-payroll' => '👥',
                'admissions' => '🎓',
                'examinations' => '📋',
                'finance' => '💳',
                'it-infrastructure' => '🖥️',
                'governance' => '🏛️',
                default => '🏷️',
            };

            return (object) [
                'name' => $catName,
                'code' => $code,
                'emoji' => $emoji,
                'icon' => $catModel?->icon ?? 'folder',
                'description' => $catModel?->description,
                'sort_order' => $catModel?->sort_order ?? 999,
                'portals' => $catPortals,
            ];
        })->sortBy('sort_order');

        $allCategories = Category::orderBy('name')->get();

        $visibilityService = app(PortalVisibilityService::class);
        $user = Auth::user() ?? new User(['role' => UserRole::VC]);

        $directoryDepartments = $visibilityService->getDirectoryTree(
            $user,
            $this->departmentFilter !== 'all' ? $this->departmentFilter : null,
            $this->search ?: null,
            $this->categoryFilter !== 'all' ? (int) $this->categoryFilter : null
        );

        return view('livewire.vc.dashboard', [
            'totalPortals' => $totalPortals,
            'totalDepartments' => $allDepartments->count(),
            'totalEmployees' => $totalEmployees,
            'totalCategories' => $totalCategories,
            'portals' => $portals,
            'departments' => $departments,
            'categories' => $categories,
            'directoryDepartments' => $directoryDepartments,
            'designs' => PortalDisplayDesign::cases(),
            'allDepartments' => $allDepartments,
            'allCategories' => $allCategories,
        ])->layout('layouts.vc', ['title' => 'Vice Chancellor Executive Portal Dashboard']);
    }
}
