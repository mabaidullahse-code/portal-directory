<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Portal\PortalForm;
use App\Livewire\Vc\Dashboard as VcDashboard;
use Illuminate\Support\Facades\Route;

// Root redirect to Filament panel
Route::get('/', function () {
    return redirect('/admin');
});

// Passwordless Vice Chancellor Executive Portal Dashboard (Public Direct Access)
Route::get('/vc/dashboard', VcDashboard::class)->name('vc.dashboard');
Route::get('/vc', VcDashboard::class)->name('vc.index');

// Organization Portal Directory & Universal Portals
Route::middleware(['auth'])->group(function () {
    Route::get('/directory', function () {
        return redirect()->route('filament.admin.pages.portal-directory');
    })->name('directory.index');
    Route::get('/reports', function () {
        return redirect()->route('filament.admin.pages.reports');
    })->name('reports.index');
    Route::get('/portals/create', PortalForm::class)->name('portals.create');
    Route::get('/portals/{portal}/edit', PortalForm::class)->name('portals.edit');
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

    // Legacy employee & admin route aliases
    Route::get('/employee/portals', function () {
        return redirect()->route('filament.admin.resources.portals.index');
    })->name('employee.portals.index');

    Route::middleware('role:admin')->get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

    Route::get('/admin/departments/import', function () {
        return redirect()->route('filament.admin.pages.department-import');
    })->name('admin.departments.import');

    Route::get('/director/dashboard', function () {
        return redirect('/admin');
    })->name('director.dashboard');

    Route::get('/employee/dashboard', function () {
        return redirect('/admin');
    })->name('employee.dashboard');
});
