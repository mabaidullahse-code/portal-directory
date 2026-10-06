<?php

namespace Tests\Feature;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Livewire\Portal\PortalForm;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use App\Services\PortalVisibilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PortalManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Department $deptIT;
    protected Department $deptFinance;
    protected User $admin;
    protected User $directorIT;
    protected User $employeeA;
    protected User $employeeB;
    protected User $financeEmployee;
    protected Portal $portalIT;
    protected Portal $portalFinance;

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

        $this->employeeB = User::create([
            'name' => 'Ahmed Khan',
            'email' => 'ahmed@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptIT->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->financeEmployee = User::create([
            'name' => 'Zainab Bibi',
            'email' => 'zainab@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $this->deptFinance->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->portalIT = Portal::create([
            'title' => 'Leave Portal',
            'url' => 'https://leaves.test.org',
            'purpose' => 'Leave management',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->employeeA->id,
            'department_id' => $this->deptIT->id,
        ]);

        $this->portalFinance = Portal::create([
            'title' => 'Payroll Portal',
            'url' => 'https://payroll.test.org',
            'purpose' => 'Salary slips',
            'status' => PortalStatus::ACTIVE,
            'user_id' => $this->financeEmployee->id,
            'department_id' => $this->deptFinance->id,
        ]);
    }

    public function test_employee_can_create_portal_with_automatic_department(): void
    {
        $this->actingAs($this->employeeA);

        Livewire::test(PortalForm::class)
            ->set('title', 'Attendance Tracking System')
            ->set('url', 'attendance.test.org')
            ->set('purpose', 'Biometric tracking')
            ->set('status', 'active')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('portals', [
            'title' => 'Attendance Tracking System',
            'url' => 'https://attendance.test.org',
            'user_id' => $this->employeeA->id,
            'department_id' => $this->deptIT->id,
        ]);
    }

    public function test_portal_visibility_service_enforces_scoping(): void
    {
        $visibilityService = new PortalVisibilityService();

        // Admin sees all portals
        $adminPortals = $visibilityService->applyVisibleScope(Portal::query(), $this->admin)->get();
        $this->assertTrue($adminPortals->contains('id', $this->portalIT->id));
        $this->assertTrue($adminPortals->contains('id', $this->portalFinance->id));

        // Director IT sees IT portals, but NEVER sees Finance portals
        $directorPortals = $visibilityService->applyVisibleScope(Portal::query(), $this->directorIT)->get();
        $this->assertTrue($directorPortals->contains('id', $this->portalIT->id));
        $this->assertFalse($directorPortals->contains('id', $this->portalFinance->id));

        // Employee A sees their own portal
        $employeePortals = $visibilityService->applyVisibleScope(Portal::query(), $this->employeeA)->get();
        $this->assertTrue($employeePortals->contains('id', $this->portalIT->id));
        $this->assertFalse($employeePortals->contains('id', $this->portalFinance->id));
    }

    public function test_director_cannot_view_or_manage_other_department_portal(): void
    {
        $visibilityService = new PortalVisibilityService();

        $this->assertTrue($visibilityService->canView($this->directorIT, $this->portalIT));
        $this->assertFalse($visibilityService->canView($this->directorIT, $this->portalFinance));

        // Can manage own portals only
        $this->assertFalse($visibilityService->canManage($this->directorIT, $this->portalFinance));
    }
}
