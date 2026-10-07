<?php

namespace Tests\Feature;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Filament\Pages\Reports;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use App\Services\PortalReportService;
use App\Services\PortalVisibilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReportGenerationTest extends TestCase
{
    use RefreshDatabase;

    protected Department $deptIT;

    protected Department $deptFinance;

    protected User $admin;

    protected User $directorIT;

    protected User $employeeA;

    protected User $employeeFinance;

    protected Portal $portalIT;

    protected Portal $portalFinance;

    protected PortalReportService $reportService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deptIT = Department::create([
            'name' => 'IT Software Wing',
            'code' => 'ITSW',
            'status' => 'active',
        ]);

        $this->deptFinance = Department::create([
            'name' => 'Finance & Accounts',
            'code' => 'FIN',
            'status' => 'active',
        ]);

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->directorIT = User::create([
            'name' => 'Director IT',
            'email' => 'director.it@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::DIRECTOR,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->employeeA = User::create([
            'name' => 'Muhammad Ali',
            'email' => 'ali@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->employeeFinance = User::create([
            'name' => 'Zainab Bibi',
            'email' => 'zainab@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptFinance->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->portalIT = Portal::create([
            'title' => 'Leave Management System',
            'url' => 'https://leaves.test.org',
            'purpose' => 'Leave workflow',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employeeA->id,
            'department_id' => $this->deptIT->id,
        ]);

        $this->portalFinance = Portal::create([
            'title' => 'Payroll Processing System',
            'url' => 'https://payroll.test.org',
            'purpose' => 'Payroll disbursement',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employeeFinance->id,
            'department_id' => $this->deptFinance->id,
        ]);

        $this->reportService = new PortalReportService(new PortalVisibilityService);
    }

    public function test_admin_report_contains_all_departments_and_portals(): void
    {
        $data = $this->reportService->prepareReportData($this->admin);

        $this->assertEquals(2, $data['summary']['total_portals']);
        $this->assertEquals(2, $data['summary']['total_departments']);
    }

    public function test_director_report_is_strictly_scoped_to_their_department(): void
    {
        $data = $this->reportService->prepareReportData($this->directorIT);

        $this->assertEquals(1, $data['summary']['total_portals']);
        $this->assertEquals(1, $data['summary']['total_departments']);
        $this->assertEquals($this->deptIT->id, $data['departments'][0]['department']->id);
    }

    public function test_standalone_html_report_renders_successfully(): void
    {
        $html = $this->reportService->generateStandaloneHtml($this->admin);

        $this->assertStringContainsString('Portal Directory & Inventory Report', $html);
        $this->assertStringContainsString('Leave Management System', $html);
        $this->assertStringContainsString('Payroll Processing System', $html);
        $this->assertStringContainsString('https://leaves.test.org', $html);
        $this->assertStringContainsString('<style>', $html);
    }

    public function test_pdf_report_generates_valid_pdf_content(): void
    {
        $pdf = $this->reportService->generatePdf($this->admin);
        $binary = $pdf->output();

        $this->assertNotEmpty($binary);
        $this->assertStringStartsWith('%PDF', $binary);
    }

    public function test_livewire_download_pdf_and_html_actions(): void
    {
        $this->actingAs($this->admin);

        Livewire::actingAs($this->admin)
            ->test(Reports::class)
            ->call('downloadPdf')
            ->assertFileDownloaded();

        Livewire::actingAs($this->admin)
            ->test(Reports::class)
            ->call('downloadExcel')
            ->assertFileDownloaded();

        Livewire::actingAs($this->admin)
            ->test(Reports::class)
            ->call('downloadHtml')
            ->assertFileDownloaded();
    }

    public function test_report_handles_portals_with_null_department_and_target_department(): void
    {
        Portal::create([
            'title' => 'Public MBBS Portal',
            'url' => 'https://admissions.test.org',
            'purpose' => 'MBBS Admissions',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employeeA->id,
            'department_id' => null,
            'target_department' => 'Admissions',
        ]);

        Portal::create([
            'title' => 'Universal Institutional Portal',
            'url' => 'https://universal.test.org',
            'purpose' => 'General purpose',
            'status' => PortalStatus::ACTIVE,
            'user_id' => null,
            'department_id' => null,
            'target_department' => null,
        ]);

        $this->actingAs($this->admin);

        Livewire::actingAs($this->admin)
            ->test(Reports::class)
            ->assertOk()
            ->assertSee('Admissions')
            ->assertSee('General & Universal Systems')
            ->assertSee('Public MBBS Portal')
            ->assertSee('Universal Institutional Portal');

        $html = $this->reportService->generateStandaloneHtml($this->admin);
        $this->assertStringContainsString('Admissions', $html);
        $this->assertStringContainsString('General &amp; Universal Systems', $html);

        $pdf = $this->reportService->generatePdf($this->admin);
        $this->assertNotEmpty($pdf->output());
    }
}
