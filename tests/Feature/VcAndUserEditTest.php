<?php

namespace Tests\Feature;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Livewire\Admin\Users\UserIndex;
use App\Livewire\Vc\Dashboard as VcDashboard;
use App\Models\Department;
use App\Models\Portal;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class VcAndUserEditTest extends TestCase
{
    use RefreshDatabase;

    protected Department $deptA;

    protected Department $deptB;

    protected User $admin;

    protected User $vc;

    protected User $employeeA;

    protected Portal $portalA;

    protected Portal $portalB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deptA = Department::create([
            'name' => 'Department Alpha',
            'code' => 'D-A',
            'status' => 'active',
        ]);

        $this->deptB = Department::create([
            'name' => 'Department Beta',
            'code' => 'D-B',
            'status' => 'active',
        ]);

        $this->admin = User::create([
            'name' => 'Admin User',
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

        $this->employeeA = User::create([
            'name' => 'Staff Member',
            'employee_id' => 'EMP-1001',
            'email' => 'staff@test.org',
            'password' => bcrypt('Password123!'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptA->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->portalA = Portal::create([
            'title' => 'Alpha Academic System',
            'url' => 'https://alpha.test.org',
            'purpose' => 'Academic portal for department Alpha',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employeeA->id,
            'department_id' => $this->deptA->id,
        ]);

        $this->portalB = Portal::create([
            'title' => 'Beta Research Repository',
            'url' => 'https://beta.test.org',
            'purpose' => 'Research repository for department Beta',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->admin->id,
            'department_id' => $this->deptB->id,
        ]);
    }

    public function test_vc_can_login_and_is_redirected_to_vc_dashboard(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'vc@test.org',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect(route('vc.dashboard'));
        $this->assertAuthenticatedAs($this->vc);
    }

    public function test_guest_can_access_vc_dashboard_passwordless_with_welcome_message_and_link_buttons(): void
    {
        // Passwordless access: Unauthenticated visitor can access directly
        $response = $this->get(route('vc.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Welcome, Worthy Vice Chancellor');
        $response->assertSee('Vice Chancellor Executive Portal Dashboard');
        $response->assertSee('Alpha Academic System');
        $response->assertSee('Beta Research Repository');
        $response->assertSee('Open Portal');

        // Alias /vc also works passwordless
        $aliasResponse = $this->get('/vc');
        $aliasResponse->assertStatus(200);
        $aliasResponse->assertSee('Welcome, Worthy Vice Chancellor');
    }

    public function test_vc_can_access_vc_dashboard_and_view_all_portals_with_link_buttons(): void
    {
        $this->actingAs($this->vc);

        $response = $this->get(route('vc.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Welcome, Worthy Vice Chancellor');
        $response->assertSee('Vice Chancellor Executive Portal Dashboard');
        $response->assertSee('Alpha Academic System');
        $response->assertSee('Beta Research Repository');
        $response->assertSee('Open Portal');

        Livewire::test(VcDashboard::class)
            ->assertSee('Alpha Academic System')
            ->assertSee('Beta Research Repository')
            ->set('search', 'Alpha')
            ->assertSee('Alpha Academic System')
            ->assertDontSee('Beta Research Repository');
    }

    public function test_vc_dashboard_does_not_contain_visual_directory_or_admin_login_buttons(): void
    {
        $response = $this->get(route('vc.dashboard'));
        $response->assertStatus(200);

        // Elements must be removed
        $response->assertDontSee('Visual Directory');
        $response->assertDontSee('Admin Login');
        $response->assertDontSee('Passwordless Single-Page Gateway');
        $response->assertDontSee('Access Mode');
        $response->assertDontSee('Sign Out');

        // When logged in, Sign Out button should also not appear on VC dashboard
        $authResponse = $this->actingAs($this->vc)->get(route('vc.dashboard'));
        $authResponse->assertDontSee('Sign Out');
    }

    public function test_vc_dashboard_can_switch_view_layouts_across_all_directory_designs(): void
    {
        Livewire::test(VcDashboard::class)
            ->assertSee('⚡ Launch Grid')
            ->assertSee('🏛️ By Dept')
            ->assertSee('☰ Table View')
            ->call('setLayout', 'departments')
            ->assertSet('layout', 'departments')
            ->assertSee('Alpha Academic System')
            ->call('setLayout', 'categories')
            ->assertSet('layout', 'categories')
            ->assertSee('Alpha Academic System')
            ->call('setLayout', 'table')
            ->assertSet('layout', 'table')
            ->assertSee('Alpha Academic System')
            ->call('setLayout', 'radial')
            ->assertSet('layout', 'radial')
            ->assertSee('Interactive Radial Architecture')
            ->call('setLayout', 'cyber_matrix')
            ->assertSet('layout', 'cyber_matrix')
            ->assertSee('CYBER_MATRIX HUD')
            ->call('setLayout', 'constellation')
            ->assertSet('layout', 'constellation')
            ->assertSee('Orbital Starfield Command Deck')
            ->call('setLayout', 'prism_bento')
            ->assertSet('layout', 'prism_bento')
            ->assertSee('Prism Architecture')
            ->call('setLayout', 'terminal_console')
            ->assertSet('layout', 'terminal_console')
            ->assertSee('DIVISION FLIGHT OPS')
            ->call('setLayout', 'compact')
            ->assertSet('layout', 'compact')
            ->call('setLayout', 'buttons')
            ->assertSet('layout', 'buttons')
            ->assertSee('Open Portal');
    }

    public function test_vc_dashboard_can_make_any_design_the_default(): void
    {
        Livewire::test(VcDashboard::class)
            ->call('setLayout', 'categories')
            ->assertSet('layout', 'categories')
            ->call('makeDefault')
            ->assertSet('defaultDesign', 'categories');

        $this->assertEquals('categories', Setting::get('portal_directory_design'));

        // Next load should mount with this new default layout
        Livewire::test(VcDashboard::class)
            ->assertSet('layout', 'categories')
            ->assertSet('defaultDesign', 'categories')
            ->assertSee('Default')
            ->call('makeDefault', 'table')
            ->assertSet('layout', 'table')
            ->assertSet('defaultDesign', 'table');

        $this->assertEquals('table', Setting::get('portal_directory_design'));
    }

    public function test_vc_cannot_manage_portals(): void
    {
        $this->actingAs($this->vc);

        // Edit portal route policy check
        $response = $this->get(route('portals.edit', $this->portalA));
        $response->assertStatus(403);
    }

    public function test_vc_can_access_directory_and_reports(): void
    {
        $this->actingAs($this->vc);

        $dirResponse = $this->get(route('directory.index'));
        $dirResponse->assertRedirect(route('filament.admin.pages.portal-directory'));

        $followed = $this->followingRedirects()->get(route('directory.index'));
        $followed->assertStatus(200);
        $followed->assertSee('Alpha Academic System');

        $reportsResponse = $this->get(route('reports.index'));
        $reportsResponse->assertRedirect(route('filament.admin.pages.reports'));

        $followedReports = $this->followingRedirects()->get(route('reports.index'));
        $followedReports->assertStatus(200);
    }

    public function test_vc_dashboard_always_shows_report_downloads(): void
    {
        // Unauthenticated guest should see download report buttons and be able to download
        Livewire::test(VcDashboard::class)
            ->assertSee('Download PDF Report')
            ->assertSee('Download Excel Report')
            ->assertDontSee('Executive Reports')
            ->call('downloadPdf')
            ->assertFileDownloaded();

        Livewire::test(VcDashboard::class)
            ->call('downloadExcel')
            ->assertFileDownloaded();

        // Authenticated VC user should also see both download buttons and be able to download reports
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

    public function test_admin_can_edit_user_detail_including_name_email_and_role(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(UserIndex::class)
            ->call('editUser', $this->employeeA->id)
            ->assertSet('name', 'Staff Member')
            ->assertSet('email', 'staff@test.org')
            ->set('name', 'Senior Officer Staff')
            ->set('email', 'senior.staff@test.org')
            ->set('designation', 'Senior Coordinator')
            ->set('phone', '+923001234567')
            ->call('saveUser')
            ->assertHasNoErrors();

        $this->employeeA->refresh();
        $this->assertEquals('Senior Officer Staff', $this->employeeA->name);
        $this->assertEquals('senior.staff@test.org', $this->employeeA->email);
        $this->assertEquals('Senior Coordinator', $this->employeeA->designation);
        $this->assertEquals('+923001234567', $this->employeeA->phone);
    }

    public function test_admin_can_change_user_password(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(UserIndex::class)
            ->call('editUser', $this->employeeA->id)
            ->set('password', 'NewSecretPass123!')
            ->set('password_confirmation', 'NewSecretPass123!')
            ->call('saveUser')
            ->assertHasNoErrors();

        $this->employeeA->refresh();
        $this->assertTrue(Hash::check('NewSecretPass123!', $this->employeeA->password));

        // Test logging in with newly set password
        $this->post(route('logout'));
        $response = $this->post(route('login'), [
            'email' => $this->employeeA->email,
            'password' => 'NewSecretPass123!',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($this->employeeA);
    }

    public function test_admin_can_create_and_edit_vc_user(): void
    {
        $this->actingAs($this->admin);

        // Create new VC user
        Livewire::test(UserIndex::class)
            ->call('openCreateModal')
            ->set('name', 'Prof. Dr. New VC')
            ->set('email', 'new.vc@test.org')
            ->set('role', 'vc')
            ->set('password', 'SecretPass123!')
            ->set('password_confirmation', 'SecretPass123!')
            ->call('saveUser')
            ->assertHasNoErrors();

        $createdVc = User::where('email', 'new.vc@test.org')->first();
        $this->assertNotNull($createdVc);
        $this->assertEquals(UserRole::VC, $createdVc->role);
        $this->assertNull($createdVc->department_id);
    }
}
