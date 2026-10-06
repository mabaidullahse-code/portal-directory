<x-guest-layout title="Forgot Password">
    <div class="mb-4 text-sm text-slate-600">
        Forgot your password? Enter your institutional email address and we will provide a secure password reset link.
    </div>

    @if (session('demo_reset_url'))
        <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-800">
            <strong>Demo Link:</strong>
            <a href="{{ session('demo_reset_url') }}" class="underline text-blue-600 block mt-1 break-all">
                Click here to reset your password directly
            </a>
        </div>
    @endif

    <form class="space-y-4" action="{{ route('password.email') }}" method="POST">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required
                       value="{{ old('email') }}"
                       class="block w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-slate-900 py-2.5 px-4 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition">
                Email Password Reset Link
            </button>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-xs text-slate-600 hover:text-slate-900 font-medium">
                ← Return to login
            </a>
        </div>
    </form>
</x-guest-layout>
