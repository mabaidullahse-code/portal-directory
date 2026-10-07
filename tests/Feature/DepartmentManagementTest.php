<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Livewire\Admin\Departments\DepartmentIndex;
use App\Models\Department;
use App\Models\User;
use App\Services\DepartmentImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DepartmentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
        ]);
    }

    public function test_admin_can_create_department(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(DepartmentIndex::class)
            ->set('name', 'Admissions Directorate')
            ->set('short_name', 'Admissions')
            ->set('code', 'ADM-DIR')
            ->set('status', 'active')
            ->call('saveDepartment')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('departments', [
            'name' => 'Admissions Directorate',
            'code' => 'ADM-DIR',
        ]);
    }

    public function test_admin_can_edit_department(): void
    {
        $dept = Department::create([
            'name' => 'Old Department Name',
            'code' => 'OLD-DEPT',
            'status' => 'active',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(DepartmentIndex::class)
            ->call('editDepartment', $dept->id)
            ->set('name', 'Updated Department Name')
            ->call('saveDepartment')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('departments', [
            'id' => $dept->id,
            'name' => 'Updated Department Name',
        ]);
    }

    public function test_cannot_delete_department_with_assigned_users(): void
    {
        $dept = Department::create([
            'name' => 'Department With Users',
            'code' => 'DWU',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Assigned User',
            'email' => 'assigned@test.org',
            'password' => bcrypt('password'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $dept->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(DepartmentIndex::class)
            ->call('deleteDepartment', $dept->id);

        $this->assertDatabaseHas('departments', [
            'id' => $dept->id,
        ]);
    }

    public function test_department_import_service_validates_and_imports_records(): void
    {
        // Pre-create an existing department
        Department::create([
            'name' => 'Existing Dept',
            'code' => 'EXIST',
            'status' => 'active',
        ]);

        $csvContent = "name,short_name,code,description,status\n"
            ."New Dept 1,Short 1,NEW1,First new department,active\n"
            ."Existing Dept,Short 2,EXIST,Duplicate department,active\n" // duplicate name & code
            ."New Dept 2,Short 3,NEW2,Second new department,active\n";

        $tempFile = tempnam(sys_get_temp_dir(), 'dept_test_').'.csv';
        file_put_contents($tempFile, $csvContent);

        $service = new DepartmentImportService;
        $parsed = $service->parseAndValidate($tempFile);

        $this->assertEquals(2, $parsed['valid_count']);
        $this->assertEquals(1, $parsed['invalid_count']);

        $importResult = $service->importValidRows($parsed['rows']);

        $this->assertEquals(2, $importResult['imported']);
        $this->assertDatabaseHas('departments', ['code' => 'NEW1']);
        $this->assertDatabaseHas('departments', ['code' => 'NEW2']);

        unlink($tempFile);
    }
}
