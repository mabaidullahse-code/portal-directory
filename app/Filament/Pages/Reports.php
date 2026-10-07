<?php

namespace App\Filament\Pages;

use App\Services\PortalReportService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Reports extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations & Portals';

    protected static ?string $navigationLabel = 'Reports & Exports';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Portal Directory Reports & Inventory Analytics';

    protected string $view = 'filament.pages.reports';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user && ($user->isAdmin() || $user->isDirector() || $user->isVc());
    }

    public function downloadPdf(PortalReportService $reportService)
    {
        $user = Auth::user();
        $pdf = $reportService->generatePdf($user);

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            'portal-directory-report-'.now()->format('Y-m-d-His').'.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }

    public function downloadHtml(PortalReportService $reportService): StreamedResponse
    {
        $user = Auth::user();
        $html = $reportService->generateStandaloneHtml($user);

        return response()->streamDownload(
            fn () => print ($html),
            'portal-directory-report-'.now()->format('Y-m-d-His').'.html',
            ['Content-Type' => 'text/html']
        );
    }

    public function downloadExcel(PortalReportService $reportService): StreamedResponse
    {
        $user = Auth::user();
        $spreadsheet = $reportService->generateSpreadsheet($user);

        return response()->streamDownload(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            'portal-directory-report-'.now()->format('Y-m-d-His').'.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    protected function getViewData(): array
    {
        $user = Auth::user();
        $reportService = app(PortalReportService::class);
        $data = $reportService->prepareReportData($user);

        return [
            'summary' => $data['summary'],
            'departments' => $data['departments'],
            'generatedAt' => $data['generated_at'],
            'scope' => $data['department_scope'] ?? 'Organization',
            'user' => $user,
        ];
    }
}
