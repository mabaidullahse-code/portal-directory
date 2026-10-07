<?php

namespace Tests\Feature;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Filament\Pages\DirectoryDesignSettings;
use App\Filament\Pages\PortalDirectory;
use App\Filament\Pages\Reports;
use App\Filament\Pages\VcDashboard;
use App\Filament\Resources\Portals\Pages\CreatePortal;
use App\Filament\Resources\Portals\PortalResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\Department;
use App\Models\Portal;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentPortalTest extends TestCase
{
    use RefreshDatabase;

    protected Department $deptIT;

    protected User $admin;

    protected User $vc;

    protected User $director;

    protected User $employee;

    protected Portal $portal;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deptIT = Department::create([
            'name' => 'IT Systems Division',
            'code' => 'ITSD',
            'status' => 'active',
        ]);

        $this->admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.org',
            'password' => bcrypt('Password123!'),
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->vc = User::create([
            'name' => 'Prof. Dr. Vice Chancellor',
            'employee_id' => 'VC-0001',
            'email' => 'vc@test.org',
            'password' => bcrypt('Password123!'),
            'role' => UserRole::VC,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->director = User::create([
            'name' => 'Director IT',
            'email' => 'director@test.org',
            'password' => bcrypt('Password123!'),
            'role' => UserRole::DIRECTOR,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->employee = User::create([
            'name' => 'Staff Member',
            'email' => 'staff@test.org',
            'password' => bcrypt('Password123!'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->portal = Portal::create([
            'title' => 'Campus Academic Gateway',
            'url' => 'https://gateway.test.org',
            'purpose' => 'Unified campus digital portal',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employee->id,
            'department_id' => $this->deptIT->id,
        ]);
    }

    public function test_authenticated_user_can_access_filament_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Portal Directory & Systems');
    }

    public function test_create_portal_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('filament.admin.resources.portals.create'));
        $response->assertStatus(200);
        $response->assertSee('Target Department');
        $response->assertDontSee('data.user_id');
    }

    public function test_filament_create_portal_with_target_department_saves_successfully(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreatePortal::class)
            ->fillForm([
                'title' => 'Custom Target Portal',
                'slug' => 'custom-target-portal',
                'url' => 'https://custom-target.test.org',
                'status' => 'active',
                'target_department' => 'Special Health Wing',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('portals', [
            'title' => 'Custom Target Portal',
            'url' => 'https://custom-target.test.org',
            'target_department' => 'Special Health Wing',
            'user_id' => $this->admin->id,
        ]);
    }

    public function test_vc_can_access_filament_vc_dashboard(): void
    {
        $response = $this->actingAs($this->vc)->get(route('filament.admin.pages.vc-dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Vice Chancellor Oversight');
        $response->assertSee('Campus Academic Gateway');
        $response->assertSee('Open Portal');
        $response->assertDontSee('Visual Directory');

        Livewire::actingAs($this->vc)
            ->test(VcDashboard::class)
            ->assertSee('Campus Academic Gateway')
            ->assertSee('Open Portal')
            ->call('setLayout', 'radial')
            ->assertSet('viewLayout', 'radial')
            ->assertSee('Interactive Radial Architecture')
            ->call('setLayout', 'departments')
            ->assertSet('viewLayout', 'departments')
            ->assertSee('Campus Academic Gateway')
            ->call('setLayout', 'table')
            ->assertSet('viewLayout', 'table')
            ->assertSee('Campus Academic Gateway')
            ->call('setLayout', 'buttons')
            ->assertSet('viewLayout', 'buttons')
            ->assertSee('Open Portal')
            ->call('makeDefault', 'radial')
            ->assertSet('viewLayout', 'radial')
            ->assertSet('defaultDesign', 'radial');

        $this->assertEquals('radial', Setting::get('portal_directory_design'));
    }

    public function test_filament_portal_directory_page_switches_designs(): void
    {
        $response = $this->actingAs($this->admin)->get(route('filament.admin.pages.portal-directory'));
        $response->assertStatus(200);

        Livewire::actingAs($this->admin)
            ->test(PortalDirectory::class)
            ->assertSee('Campus Academic Gateway')
            ->call('selectDesign', 'radial')
            ->assertSet('design', 'radial')
            ->assertSee('Interactive Radial Architecture')
            ->call('selectDesign', 'cyber_matrix')
            ->assertSet('design', 'cyber_matrix')
            ->assertSee('CYBER_MATRIX HUD')
            ->call('selectDesign', 'constellation')
            ->assertSet('design', 'constellation')
            ->assertSee('Orbital Starfield Command Deck')
            ->call('selectDesign', 'prism_bento')
            ->assertSet('design', 'prism_bento')
            ->assertSee('Prism Architecture')
            ->call('selectDesign', 'terminal_console')
            ->assertSet('design', 'terminal_console')
            ->assertSee('DIVISION FLIGHT OPS')
            ->call('selectDesign', 'compact')
            ->assertSet('design', 'compact')
            ->call('toggleViewMode', 'table')
            ->assertSet('viewMode', 'table');
    }

    public function test_filament_reports_page_downloads_pdf_and_html(): void
    {
        $this->actingAs($this->admin);

        Livewire::actingAs($this->admin)
            ->test(Reports::class)
            ->call('downloadPdf')
            ->assertFileDownloaded();

        Livewire::actingAs($this->admin)
            ->test(Reports::class)
            ->call('downloadHtml')
            ->assertFileDownloaded();
    }

    public function test_filament_vc_dashboard_downloads_pdf_and_excel(): void
    {
        $this->actingAs($this->vc);

        Livewire::actingAs($this->vc)
            ->test(VcDashboard::class)
            ->assertSee('Download PDF Report')
            ->assertSee('Download Excel Report')
            ->assertDontSee('Executive Reports')
            ->call('downloadPdf')
            ->assertFileDownloaded();

        Livewire::actingAs($this->vc)
            ->test(VcDashboard::class)
            ->call('downloadExcel')
            ->assertFileDownloaded();
    }

    public function test_filament_directory_design_settings_saves_default(): void
    {
        $this->actingAs($this->admin);

        Livewire::actingAs($this->admin)
            ->test(DirectoryDesignSettings::class)
            ->call('selectDesign', 'cyber_matrix')
            ->call('saveDefaultDesign')
            ->assertSee("Default portal directory design successfully saved as 'cyber_matrix'");

        $this->assertEquals('cyber_matrix', Setting::get('portal_directory_design'));

        Livewire::actingAs($this->admin)
            ->test(DirectoryDesignSettings::class)
            ->call('selectDesign', 'constellation')
            ->call('saveDefaultDesign')
            ->assertSee("Default portal directory design successfully saved as 'constellation'");

        $this->assertEquals('constellation', Setting::get('portal_directory_design'));
    }

    public function test_vc_cannot_create_or_edit_portals_in_filament(): void
    {
        $this->actingAs($this->vc);

        $this->assertFalse(PortalResource::canCreate());
        $this->assertFalse(PortalResource::canEdit($this->portal));
        $this->assertFalse(PortalResource::canDelete($this->portal));
    }

    public function test_non_admin_cannot_access_user_resource(): void
    {
        $this->actingAs($this->vc);
        $this->assertFalse(UserResource::canAccess());

        $this->actingAs($this->employee);
        $this->assertFalse(UserResource::canAccess());

        $this->actingAs($this->admin);
        $this->assertTrue(UserResource::canAccess());
    }
}
