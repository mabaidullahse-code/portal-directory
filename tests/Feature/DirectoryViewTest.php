<?php

namespace Tests\Feature;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Livewire\Portal\PortalDirectory;
use App\Models\Department;
use App\Models\Portal;
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

    public function test_admin_can_access_directory_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('directory.index'));

        $response->assertStatus(200);
        $response->assertSee('Core Systems Hub');
    }

    public function test_director_can_access_directory_page(): void
    {
        $response = $this->actingAs($this->director)->get(route('directory.index'));

        $response->assertStatus(200);
        $response->assertSee('Core Systems Hub');
    }

    public function test_employee_can_access_directory_page(): void
    {
        $response = $this->actingAs($this->employee)->get(route('directory.index'));

        $response->assertStatus(200);
        $response->assertSee('Core Systems Hub');
    }

    public function test_directory_livewire_component_switches_designs(): void
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
}
