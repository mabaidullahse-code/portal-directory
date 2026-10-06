<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (!$user->isActive()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withInput($request->only('email', 'remember'))
                    ->withErrors(['email' => 'Your account is deactivated. Please contact an administrator.']);
            }

            $request->session()->regenerate();

            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            ActivityLog::record('auth.login', "User {$user->name} logged in from {$request->ip()}", $user);

            return $this->redirectBasedOnRole($user);
        }

        return back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            ActivityLog::record('auth.logout', "User {$user->name} logged out", $user);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // For local development demonstration, generate token and provide reset link
        $token = Password::broker()->createToken($user);
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);

        return back()->with('status', 'Password reset instructions ready.')
            ->with('demo_reset_url', $resetUrl);
    }

    public function showResetPassword(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Password::broker()->tokenExists($user, $request->token)) {
            return back()->withErrors(['email' => 'Invalid or expired password reset token.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        Password::broker()->deleteToken($user);

        ActivityLog::record('auth.password_reset', "Password reset for {$user->email}", $user);

        return redirect()->route('login')->with('success', 'Your password has been reset successfully. Please login.');
    }

    public function profile(): View
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'designation' => ['nullable', 'string', 'max:255'],
        ]);

        $oldValues = $user->only(['name', 'phone', 'designation']);
        $user->update($validated);

        ActivityLog::record('user.profile_updated', "Updated profile details", $user, $oldValues, $validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::record('user.password_changed', "Changed password", $user);

        return back()->with('success', 'Password changed successfully.');
    }

    public function redirectBasedOnRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            UserRole::ADMIN => redirect()->intended(route('admin.dashboard')),
            UserRole::DIRECTOR => redirect()->intended(route('director.dashboard')),
            UserRole::EMPLOYEE => redirect()->intended(route('employee.dashboard')),
            default => redirect()->intended(route('directory.index')),
        };
    }
}
