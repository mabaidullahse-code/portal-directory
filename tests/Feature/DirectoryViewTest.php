<?php

namespace Tests\Feature;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Filament\Pages\PortalDirectory;
use App\Livewire\Admin\Settings\DirectoryDesign;
use App\Models\Department;
use App\Models\Portal;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DirectoryViewTest extends TestCase
{
    use RefreshDatabase;

    protected Department $deptIT;

    protected User $admin;

    protected User $director;

    protected User $employee;

    protected Portal $portal;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deptIT = Department::create([
            'name' => 'IT Software Wing',
            'code' => 'ITSW',
            'status' => 'active',
        ]);

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->director = User::create([
            'name' => 'Director User',
            'email' => 'director@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::DIRECTOR,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->portal = Portal::create([
            'title' => 'Core Systems Hub',
            'url' => 'https://hub.test.org',
            'purpose' => 'Core system hub',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employee->id,
            'department_id' => $this->deptIT->id,
        ]);
    }

    public function test_admin_access_to_directory_redirects_to_filament(): void
    {
        $response = $this->actingAs($this->admin)->get(route('directory.index'));

        $response->assertRedirect(route('filament.admin.pages.portal-directory'));

        $followed = $this->actingAs($this->admin)->followingRedirects()->get(route('directory.index'));
        $followed->assertStatus(200);
        $followed->assertSee('Core Systems Hub');
    }

    public function test_director_access_to_directory_redirects_to_filament(): void
    {
        $response = $this->actingAs($this->director)->get(route('directory.index'));

        $response->assertRedirect(route('filament.admin.pages.portal-directory'));

        $followed = $this->actingAs($this->director)->followingRedirects()->get(route('directory.index'));
        $followed->assertStatus(200);
        $followed->assertSee('Core Systems Hub');
    }

    public function test_employee_access_to_directory_redirects_to_filament(): void
    {
        $response = $this->actingAs($this->employee)->get(route('directory.index'));

        $response->assertRedirect(route('filament.admin.pages.portal-directory'));

        $followed = $this->actingAs($this->employee)->followingRedirects()->get(route('directory.index'));
        $followed->assertStatus(200);
        $followed->assertSee('Core Systems Hub');
    }

    public function test_directory_only_shows_departments_with_portals(): void
    {
        $emptyDept = Department::create([
            'name' => 'Empty Admissions Wing',
            'code' => 'EAW',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get(route('filament.admin.pages.portal-directory'));

        $response->assertStatus(200);
        $response->assertSee('IT Software Wing');
        $response->assertSee('Core Systems Hub');
        // Ensure empty department and empty fallback message are completely absent
        $response->assertDontSee('Empty Admissions Wing');
        $response->assertDontSee('No employees with active portals registered in this department.');
    }

    public function test_directory_filament_page_switches_designs(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PortalDirectory::class)
            ->call('selectDesign', 'radial')
            ->assertSet('design', 'radial')
            ->assertSee('Interactive Radial Architecture')
            ->call('selectDesign', 'compact')
            ->assertSet('design', 'compact')
            ->call('selectDesign', 'dashboard')
            ->assertSet('design', 'dashboard');
    }

    public function test_directory_radial_design_renders_and_filters_departments(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PortalDirectory::class)
            ->call('selectDesign', 'radial')
            ->assertSet('design', 'radial')
            ->assertSee('Interactive Radial Architecture')
            ->call('selectDepartment', $this->deptIT->id)
            ->assertSet('selectedDepartmentId', $this->deptIT->id)
            ->assertSee('IT Software Wing')
            ->assertSee('Core Systems Hub');
    }

    public function test_admin_can_save_directory_design_settings(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(DirectoryDesign::class)
            ->call('selectDesign', 'radial')
            ->call('saveDefaultDesign')
            ->assertSee("Default portal directory design successfully saved as 'radial'");

        $this->assertEquals('radial', Setting::get('portal_directory_design'));
    }
}
