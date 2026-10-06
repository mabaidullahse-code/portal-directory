<x-guest-layout title="Sign In">
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
        <div class="grid grid-cols-3 gap-2">
            <button type="button"
                    onclick="fillCredentials('admin@example.org', 'Password123!')"
                    class="py-1.5 px-2 bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 rounded text-xs font-medium text-center transition">
                Admin
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
