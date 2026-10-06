<x-guest-layout title="Reset Password">
    <form class="space-y-4" action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required
                       value="{{ old('email', $email) }}"
                       class="block w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">New Password</label>
            <div class="mt-1">
                <input id="password" name="password" type="password" autocomplete="new-password" required
                       class="block w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm New Password</label>
            <div class="mt-1">
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                       class="block w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
            </div>
        </div>

        <div>
            <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-slate-900 py-2.5 px-4 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition">
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>
