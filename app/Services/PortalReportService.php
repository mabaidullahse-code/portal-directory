<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PortalReportService
{
    public function __construct(
        protected PortalVisibilityService $visibilityService
    ) {}

    /**
     * Prepare structured report data respecting user permissions.
     */
    public function prepareReportData(?User $user = null, array $filters = []): array
    {
        $deptQuery = Department::query()->active()->orderBy('name');

        if ($user && ! $user->isAdmin() && ! $user->isVc()) {
            if ($user->department_id) {
                $deptQuery->where('id', $user->department_id);
            } else {
                $deptQuery->whereRaw('1 = 0');
            }
        } elseif (! empty($filters['department_id'])) {
            $deptQuery->where('id', $filters['department_id']);
        }

        $departments = $deptQuery->get();

        $portalQuery = Portal::query()
            ->with(['user', 'department', 'category', 'targetDepartments'])
            ->orderBy('sort_order')
            ->orderBy('title');

        if ($user && ! $user->isAdmin() && ! $user->isVc()) {
            $this->visibilityService->applyVisibleScope($portalQuery, $user);
        } else {
            $portalQuery->active();
        }

        // Apply filters
        if (! empty($filters['department_id'])) {
            $portalQuery->where('department_id', $filters['department_id']);
        }

        if (! empty($filters['user_id'])) {
            $portalQuery->where('user_id', $filters['user_id']);
        }

        if (! empty($filters['status']) && $filters['status'] !== 'all') {
            $portalQuery->where('status', $filters['status']);
        }

        if (! empty($filters['category_id'])) {
            $portalQuery->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['date_from'])) {
            $portalQuery->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $portalQuery->whereDate('created_at', '<=', $filters['date_to']);
        }

        $portals = $portalQuery->get();

        $realDepartments = Department::active()->orderBy('name')->get()->keyBy('id');

        $grouped = [];
        $totalPortals = $portals->count();
        $activePortals = $portals->where('status.value', 'active')->count();
        $inactivePortals = $totalPortals - $activePortals;

        foreach ($portals as $portal) {
            $deptKey = null;
            $deptModel = null;

            if ($portal->department_id && isset($realDepartments[$portal->department_id])) {
                $deptKey = 'dept_'.$portal->department_id;
                $deptModel = $realDepartments[$portal->department_id];
            } elseif ($portal->department) {
                $deptKey = 'dept_'.$portal->department->id;
                $deptModel = $portal->department;
            } elseif (! empty($portal->target_department)) {
                $deptKey = 'target_'.Str::slug($portal->target_department);
                $code = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $portal->target_department), 0, 4)) ?: 'TGT';
                $deptModel = new Department([
                    'name' => $portal->target_department,
                    'short_name' => $portal->target_department,
                    'code' => $code,
                    'status' => 'active',
                ]);
                $deptModel->id = abs(crc32($portal->target_department));
            } elseif ($portal->targetDepartments->isNotEmpty()) {
                $firstTarget = $portal->targetDepartments->first();
                $deptKey = 'dept_'.$firstTarget->id;
                $deptModel = $firstTarget;
            } elseif ($portal->user?->department_id && isset($realDepartments[$portal->user->department_id])) {
                $deptKey = 'dept_'.$portal->user->department_id;
                $deptModel = $realDepartments[$portal->user->department_id];
            } else {
                $deptKey = 'universal';
                $deptModel = new Department([
                    'name' => 'General & Universal Systems',
                    'short_name' => 'Universal',
                    'code' => 'UNIV',
                    'status' => 'active',
                ]);
                $deptModel->id = 0;
            }

            $creator = $portal->user ?: new User([
                'name' => $portal->contact_person ?: 'System Administrator',
                'email' => $portal->contact_email ?: 'admin@uhs.edu.pk',
                'designation' => 'Portal Custodian',
                'role' => UserRole::EMPLOYEE,
                'status' => UserStatus::ACTIVE,
            ]);
            if (! $creator->id) {
                $creator->id = 0;
            }

            $empKey = 'user_'.$creator->id;

            if (! isset($grouped[$deptKey])) {
                $grouped[$deptKey] = [
                    'department' => $deptModel,
                    'employees_map' => [],
                    'portals' => collect(),
                ];
            }

            $grouped[$deptKey]['portals']->push($portal);

            if (! isset($grouped[$deptKey]['employees_map'][$empKey])) {
                $grouped[$deptKey]['employees_map'][$empKey] = [
                    'employee' => $creator,
                    'portals' => collect(),
                ];
            }

            $grouped[$deptKey]['employees_map'][$empKey]['portals']->push($portal);
        }

        $groupedData = [];
        $uniqueEmployees = collect();

        foreach ($grouped as $deptGroup) {
            $deptEmployees = [];
            foreach ($deptGroup['employees_map'] as $empGroup) {
                $empPortals = $empGroup['portals'];
                $deptEmployees[] = [
                    'employee' => $empGroup['employee'],
                    'portals' => $empPortals,
                    'total' => $empPortals->count(),
                    'active' => $empPortals->where('status.value', 'active')->count(),
                    'inactive' => $empPortals->where('status.value', 'inactive')->count(),
                ];
                $uniqueEmployees->put($empGroup['employee']->id ?: $empGroup['employee']->name, true);
            }

            $deptPortals = $deptGroup['portals'];
            $groupedData[] = [
                'department' => $deptGroup['department'],
                'employees' => $deptEmployees,
                'total_portals' => $deptPortals->count(),
                'active_portals' => $deptPortals->where('status.value', 'active')->count(),
                'inactive_portals' => $deptPortals->where('status.value', 'inactive')->count(),
            ];
        }

        $appliedDepartmentName = 'All Departments';
        if (! empty($filters['department_id'])) {
            $appliedDepartmentName = Department::find($filters['department_id'])?->name ?? 'All Departments';
        } elseif ($user && ! $user->isAdmin() && ! $user->isVc()) {
            $appliedDepartmentName = $user->department?->name ?? 'Department';
        }

        $reportUser = $user ?? new User([
            'name' => 'Worthy Vice Chancellor',
            'email' => 'vc@uhs.edu.pk',
            'role' => UserRole::VC,
            'status' => UserStatus::ACTIVE,
            'designation' => 'Vice Chancellor',
        ]);

        return [
            'title' => 'Portal Directory Report',
            'generated_at' => now(),
            'generated_by' => $reportUser,
            'organization_name' => config('app.name', 'Organization Portal Directory'),
            'department_scope' => $appliedDepartmentName,
            'filters' => $filters,
            'departments' => $groupedData,
            'summary' => [
                'total_portals' => $totalPortals,
                'active_portals' => $activePortals,
                'inactive_portals' => $inactivePortals,
                'total_departments' => count($groupedData),
                'total_employees' => $uniqueEmployees->count(),
            ],
        ];
    }

    /**
     * Generate PDF binary stream or download.
     */
    public function generatePdf(?User $user = null, array $filters = []): \Barryvdh\DomPDF\PDF
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
    public function generateStandaloneHtml(?User $user = null, array $filters = []): string
    {
        $data = $this->prepareReportData($user, $filters);

        return View::make('reports.portals-html', $data)->render();
    }

    /**
     * Generate Excel spreadsheet workbook for portal inventory.
     */
    public function generateSpreadsheet(?User $user = null, array $filters = []): Spreadsheet
    {
        $data = $this->prepareReportData($user, $filters);
        $generatedByName = $data['generated_by']?->name ?? 'Executive Office';

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Portal Inventory');

        // Document Properties
        $spreadsheet->getProperties()
            ->setCreator($generatedByName)
            ->setTitle($data['title'])
            ->setSubject('Portal Directory Inventory Report');

        // Title Block
        $sheet->setCellValue('A1', config('app.name', 'Organization Portal Directory'));
        $sheet->setCellValue('A2', 'Official Portal Systems Directory & Inventory Report');
        $sheet->setCellValue('A3', 'Scope: '.$data['department_scope'].' | Generated: '.$data['generated_at']->format('M d, Y h:i A').' by '.$generatedByName);

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new Color('FF1E3A8A'));
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FF334155'));
        $sheet->getStyle('A3')->getFont()->setSize(9)->setColor(new Color('FF64748B'));

        // KPI Summary Block
        $sheet->setCellValue('A5', 'SUMMARY KPI:');
        $sheet->setCellValue('B5', 'Total Portals: '.$data['summary']['total_portals']);
        $sheet->setCellValue('D5', 'Active: '.$data['summary']['active_portals']);
        $sheet->setCellValue('F5', 'Inactive: '.$data['summary']['inactive_portals']);
        $sheet->setCellValue('H5', 'Departments: '.$data['summary']['total_departments']);
        $sheet->setCellValue('J5', 'Employees: '.$data['summary']['total_employees']);
        $sheet->getStyle('A5:J5')->getFont()->setBold(true)->setSize(10);

        // Header Row
        $row = 7;
        $headers = [
            'A' => '#',
            'B' => 'Department Code',
            'C' => 'Department Name',
            'D' => 'Custodian / Employee',
            'E' => 'Designation',
            'F' => 'Portal Title',
            'G' => 'Category',
            'H' => 'Purpose',
            'I' => 'Description',
            'J' => 'Endpoint URL',
            'K' => 'Status',
            'L' => 'Opening Date',
            'M' => 'Closing Date',
            'N' => 'Contact Person',
            'O' => 'Contact Email',
        ];

        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col.$row, $header);
        }

        $headerRange = 'A'.$row.':O'.$row;
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '334155'],
                ],
            ],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(26);

        $row++;
        $counter = 1;

        foreach ($data['departments'] as $deptData) {
            $dept = $deptData['department'];
            $deptCode = $dept?->code ?? 'UNIV';
            $deptName = $dept?->name ?? 'General & Universal Systems';

            foreach ($deptData['employees'] as $empData) {
                $employee = $empData['employee'];
                $empName = $employee?->name ?? 'Staff';
                $designation = $employee?->designation ?: 'Staff';

                foreach ($empData['portals'] as $portal) {
                    $sheet->setCellValue('A'.$row, $counter);
                    $sheet->setCellValue('B'.$row, $deptCode);
                    $sheet->setCellValue('C'.$row, $deptName);
                    $sheet->setCellValue('D'.$row, $empName);
                    $sheet->setCellValue('E'.$row, $designation);
                    $sheet->setCellValue('F'.$row, $portal->title);
                    $sheet->setCellValue('G'.$row, $portal->category?->name ?? '—');
                    $sheet->setCellValue('H'.$row, $portal->purpose ?: '—');
                    $sheet->setCellValue('I'.$row, $portal->description ?: '—');
                    $sheet->setCellValue('J'.$row, $portal->safe_url);
                    $sheet->setCellValue('K'.$row, $portal->computed_status->label());
                    $sheet->setCellValue('L'.$row, $portal->opening_date?->format('Y-m-d') ?? '—');
                    $sheet->setCellValue('M'.$row, $portal->closing_date?->format('Y-m-d') ?? '—');
                    $sheet->setCellValue('N'.$row, $portal->contact_person ?: '—');
                    $sheet->setCellValue('O'.$row, $portal->contact_email ?: '—');

                    if (! empty($portal->safe_url)) {
                        $sheet->getCell('J'.$row)->getHyperlink()->setUrl($portal->safe_url);
                        $sheet->getStyle('J'.$row)->getFont()->setColor(new Color('FF2563EB'))->setUnderline(true);
                    }

                    $statusColor = match ($portal->computed_status->value) {
                        'active' => '15803D',
                        'inactive' => 'B91C1C',
                        'scheduled' => 'D97706',
                        'expired' => '64748B',
                        default => '334155',
                    };
                    $sheet->getStyle('K'.$row)->getFont()->setBold(true)->setColor(new Color('FF'.$statusColor));

                    $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray([
                        'font' => ['size' => 9],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_HAIR,
                                'color' => ['rgb' => 'CBD5E1'],
                            ],
                        ],
                    ]);

                    if ($counter % 2 === 0) {
                        $sheet->getStyle('A'.$row.':O'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
                    }

                    $sheet->getRowDimension($row)->setRowHeight(20);
                    $row++;
                    $counter++;
                }
            }
        }

        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }
}
