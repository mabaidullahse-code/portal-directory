<?php

namespace Tests\Feature;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $directorIT;
    protected User $directorFinance;
    protected User $employeeA;
    protected User $employeeB;
    protected Department $deptIT;
    protected Department $deptFinance;
    protected Portal $portalA;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deptIT = Department::create([
            'name' => 'IT Software Wing',
            'code' => 'ITSW',
            'status' => 'active',
        ]);

        $this->deptFinance = Department::create([
            'name' => 'Finance Wing',
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

        $this->directorFinance = User::create([
            'name' => 'Director Finance',
            'email' => 'director.finance@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::DIRECTOR,
            'department_id' => $this->deptFinance->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->employeeA = User::create([
            'name' => 'Employee A',
            'email' => 'emp.a@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->employeeB = User::create([
            'name' => 'Employee B',
            'email' => 'emp.b@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->portalA = Portal::create([
            'title' => 'Portal A',
            'url' => 'https://portala.test.org',
            'purpose' => 'System A',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employeeA->id,
            'department_id' => $this->deptIT->id,
        ]);
    }

    public function test_employee_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->employeeA)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_director_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->directorIT)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_employee_cannot_edit_another_employees_portal(): void
    {
        $response = $this->actingAs($this->employeeB)->get(route('portals.edit', $this->portalA));
        $response->assertStatus(403);
    }

    public function test_employee_can_edit_their_own_portal(): void
    {
        $response = $this->actingAs($this->employeeA)->get(route('portals.edit', $this->portalA));
        $response->assertStatus(200);
    }

    public function test_admin_can_edit_any_portal(): void
    {
        $response = $this->actingAs($this->admin)->get(route('portals.edit', $this->portalA));
        $response->assertStatus(200);
    }
}
