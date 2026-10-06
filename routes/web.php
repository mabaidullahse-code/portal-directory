<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Admin\ActivityLogs\ActivityLogIndex;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Departments\DepartmentImport;
use App\Livewire\Admin\Departments\DepartmentIndex;
use App\Livewire\Admin\Portals\PortalIndex as AdminPortalIndex;
use App\Livewire\Admin\Settings\DirectoryDesign;
use App\Livewire\Admin\Users\UserIndex;
use App\Livewire\Director\Dashboard as DirectorDashboard;
use App\Livewire\Director\DepartmentEmployees;
use App\Livewire\Director\DepartmentPortals;
use App\Livewire\Director\MyPortals as DirectorMyPortals;
use App\Livewire\Employee\Dashboard as EmployeeDashboard;
use App\Livewire\Employee\Portals\PortalIndex as EmployeePortalIndex;
use App\Livewire\Portal\PortalDirectory;
use App\Livewire\Portal\PortalForm;
use App\Livewire\Reports\ReportIndex;
use Illuminate\Support\Facades\Route;

// Root redirect to directory or login
Route::get('/', function () {
    return redirect()->route('directory.index');
});

// Main Organization Portal Directory (Accessible to all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/directory', PortalDirectory::class)->name('directory.index');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated Shared Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Settings
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.show');
    Route::patch('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');

    // Portal Registration & Editing (Universal form with auto-assigned ownership)
    Route::get('/portals/create', PortalForm::class)->name('portals.create');
    Route::get('/portals/{portal}/edit', PortalForm::class)->name('portals.edit');

    // Reports & Exports (Accessible to Admin & Director)
    Route::get('/reports', ReportIndex::class)
        ->middleware('role:admin,director')
        ->name('reports.index');
});

// Admin Exclusive Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/departments', DepartmentIndex::class)->name('departments.index');
    Route::get('/departments/import', DepartmentImport::class)->name('departments.import');
    Route::get('/portals', AdminPortalIndex::class)->name('portals.index');
    Route::get('/settings/directory-design', DirectoryDesign::class)->name('settings.design');
    Route::get('/activity-logs', ActivityLogIndex::class)->name('activity-logs.index');
});

// Director Exclusive Routes
Route::middleware(['auth', 'role:director'])->prefix('director')->name('director.')->group(function () {
    Route::get('/dashboard', DirectorDashboard::class)->name('dashboard');
    Route::get('/my-portals', DirectorMyPortals::class)->name('my-portals');
    Route::get('/employees', DepartmentEmployees::class)->name('employees');
    Route::get('/department-portals', DepartmentPortals::class)->name('department-portals');
});

// Employee Exclusive Routes
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', EmployeeDashboard::class)->name('dashboard');
    Route::get('/portals', EmployeePortalIndex::class)->name('portals.index');
});
