<?php

use App\Izin\Http\Controllers\Auth\AdminController;
use App\Izin\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Izin\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Izin\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Izin\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Izin\Http\Controllers\Auth\NewPasswordController;
use App\Izin\Http\Controllers\Auth\PasswordController;
use App\Izin\Http\Controllers\Auth\PasswordResetLinkController;
use App\Izin\Http\Controllers\Auth\RegisteredUserController;
use App\Izin\Http\Controllers\Auth\VerifyEmailController;
use App\Izin\Http\Controllers\Auth\SuperadminController;
use App\Izin\Http\Controllers\Auth\UserController;
use App\Izin\Http\Controllers\Auth\RoleSwitchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes (Role-Based)
|--------------------------------------------------------------------------
*/

// To Dashboard Superadmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperadminController::class, 'index'])
        ->name('superadmin.dashboard');
});

// To Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});

// To Dashboard User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])
        ->name('user.dashboard');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot or Reset Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Password Confirmation & Update
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    // Switch Panel (Admin <-> Superadmin)
    Route::post('/switch-panel/{role}', function ($role) {
        if (!in_array($role, ['admin', 'superadmin'])) {
            abort(403);
        }

        // hanya superadmin boleh switch
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        session(['active_role' => $role]);

        // ✅ redirect sesuai panel
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        abort(403);
    })->middleware('auth')->name('switch.panel');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // ✅ DEVELOPMENT ONLY: Role Switcher (untuk testing multiple roles)
    if (app()->isLocal()) {
        Route::get('/dev/switch-user', [RoleSwitchController::class, 'showSwitcher'])
            ->name('dev.switch-user');
        Route::post('/dev/switch-user', [RoleSwitchController::class, 'switchUser'])
            ->name('dev.switch-user-store');
    }
});
