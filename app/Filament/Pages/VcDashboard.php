<?php

namespace App\Filament\Pages;

use App\Enums\PortalDisplayDesign;
use App\Models\Category;
use App\Models\Department;
use App\Models\Portal;
use App\Models\Setting;
use App\Models\User;
use App\Services\PortalReportService;
use App\Services\PortalVisibilityService;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VcDashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'Directory & Access';

    protected static ?string $navigationLabel = 'VC Dashboard';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Vice Chancellor Executive Portal Dashboard';

    protected string $view = 'filament.pages.vc-dashboard';

    public string $search = '';

    public string $departmentFilter = 'all';

    public string $categoryFilter = 'all';

    public string $viewLayout = 'buttons';

    public string $defaultDesign = 'buttons';

    public function mount(): void
    {
        $saved = Setting::get('portal_directory_design', 'buttons');
        $this->defaultDesign = $saved;
        if ($saved && (PortalDisplayDesign::tryFrom($saved) || in_array($saved, ['buttons', 'departments', 'categories', 'table']))) {
            $this->viewLayout = $saved;
        }
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user && ($user->isVc() || $user->isAdmin());
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
        $this->viewLayout = $layout;
    }

    public function makeDefault(?string $layoutToSet = null): void
    {
        $target = $layoutToSet ?: $this->viewLayout;
        Setting::set('portal_directory_design', $target);
        $this->defaultDesign = $target;
        $this->viewLayout = $target;

        Notification::make()
            ->title('Default Layout Updated')
            ->body("The directory view '{$target}' has been set as the default design.")
            ->success()
            ->send();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->departmentFilter = 'all';
        $this->categoryFilter = 'all';
    }

    protected function getViewData(): array
    {
        $user = Auth::user();
        $visibilityService = app(PortalVisibilityService::class);

        $query = Portal::query()
            ->with(['department', 'category', 'user'])
            ->active();

        $query = $visibilityService->applyVisibleScope($query, $user);

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->departmentFilter !== 'all') {
            if (str_starts_with($this->departmentFilter, 'target:')) {
                $targetName = substr($this->departmentFilter, 7);
                $query->where('target_department', $targetName);
            } else {
                $query->where('department_id', (int) $this->departmentFilter);
            }
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category_id', (int) $this->categoryFilter);
        }

        $portals = $query->orderBy('sort_order')->orderBy('title')->get();

        $realDepartments = Department::active()
            ->whereHas('portals', fn ($pq) => $pq->active())
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

        $allCategories = Category::active()->orderBy('name')->get();

        // Departments for grouped view
        $groupedDepartments = $portals->groupBy(function ($p) {
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

        $groupedCategories = $portals->groupBy(function ($p) {
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

        $directoryDepartments = $visibilityService->getDirectoryTree(
            $user,
            $this->departmentFilter !== 'all' ? $this->departmentFilter : null,
            $this->search ?: null,
            $this->categoryFilter !== 'all' ? (int) $this->categoryFilter : null
        );

        return [
            'portals' => $portals,
            'departments' => $groupedDepartments,
            'categories' => $groupedCategories,
            'directoryDepartments' => $directoryDepartments,
            'designs' => PortalDisplayDesign::cases(),
            'defaultDesign' => $this->defaultDesign,
            'allDepartments' => $allDepartments,
            'allCategories' => $allCategories,
            'totalPortals' => Portal::active()->count(),
            'totalDepartments' => $allDepartments->count(),
            'totalCategories' => $allCategories->count(),
            'totalEmployees' => User::active()->count(),
        ];
    }
}
