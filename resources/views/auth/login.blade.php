<x-guest-layout title="Sign In">
    <!-- Vice Chancellor Passwordless Direct Access Banner -->
    <div class="mb-5 p-4 rounded-xl bg-blue-50/80 border border-blue-200/80 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm shadow-xs shrink-0">🏛️</div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-slate-900 truncate">Vice Chancellor Executive Gateway</p>
                <p class="text-[11px] text-slate-600 truncate">Passwordless one-click direct access</p>
            </div>
        </div>
        <a href="{{ route('vc.dashboard') }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold shadow-xs transition shrink-0">
            <span>Direct Access</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>

    <form class="space-y-5" action="{{ route('login') }}" method="POST">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required
                       value="{{ old('email') }}"
                       class="block w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm @error('email') border-rose-500 @enderror">
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-500">
                    Forgot password?
                </a>
            </div>
            <div class="mt-1">
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="block w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm @error('password') border-rose-500 @enderror">
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                       class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <label for="remember" class="ml-2 block text-sm text-slate-600">Remember me</label>
            </div>
        </div>

        <div>
            <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-slate-900 py-2.5 px-4 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition">
                Sign In to Portal
            </button>
        </div>
    </form>

    <!-- Quick Role Fill Demo Widget -->
    <div class="mt-6 pt-6 border-t border-slate-200">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 text-center">
            One-Click Demo Credentials
        </p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            <button type="button"
                    onclick="fillCredentials('admin@example.org', 'Password123!')"
                    class="py-1.5 px-2 bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 rounded text-xs font-medium text-center transition">
                Admin
            </button>
            <button type="button"
                    onclick="fillCredentials('vc@example.org', 'Password123!')"
                    class="py-1.5 px-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded text-xs font-medium text-center transition">
                VC
            </button>
            <button type="button"
                    onclick="fillCredentials('director.it@example.org', 'Password123!')"
                    class="py-1.5 px-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded text-xs font-medium text-center transition">
                Director
            </button>
            <button type="button"
                    onclick="fillCredentials('ali@example.org', 'Password123!')"
                    class="py-1.5 px-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded text-xs font-medium text-center transition">
                Employee
            </button>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
