<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Sign In to Portal');
    }

    public function test_admin_can_login_and_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.org',
            'password' => bcrypt('password123'),
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.org',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_director_can_login_and_is_redirected_to_director_dashboard(): void
    {
        $dept = Department::create([
            'name' => 'IT Wing',
            'code' => 'ITW',
            'status' => 'active',
        ]);

        $director = User::create([
            'name' => 'Director User',
            'email' => 'director@test.org',
            'password' => bcrypt('password123'),
            'role' => UserRole::DIRECTOR,
            'department_id' => $dept->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $response = $this->post('/login', [
            'email' => 'director@test.org',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('director.dashboard'));
        $this->assertAuthenticatedAs($director);
    }

    public function test_employee_can_login_and_is_redirected_to_employee_dashboard(): void
    {
        $dept = Department::create([
            'name' => 'HR Wing',
            'code' => 'HRW',
            'status' => 'active',
        ]);

        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@test.org',
            'password' => bcrypt('password123'),
            'role' => UserRole::EMPLOYEE,
            'department_id' => $dept->id,
            'status' => UserStatus::ACTIVE,
        ]);

        $response = $this->post('/login', [
            'email' => 'employee@test.org',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('employee.dashboard'));
        $this->assertAuthenticatedAs($employee);
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@test.org',
            'password' => bcrypt('password123'),
            'role' => UserRole::EMPLOYEE,
            'status' => UserStatus::INACTIVE,
        ]);

        $response = $this->post('/login', [
            'email' => 'inactive@test.org',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Active User',
            'email' => 'user@test.org',
            'password' => bcrypt('password123'),
            'role' => UserRole::EMPLOYEE,
            'status' => UserStatus::ACTIVE,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
