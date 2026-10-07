<x-app-layout title="User Profile">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">User Profile</h1>
        <p class="text-xs text-slate-500">Manage your personal account credentials and display details.</p>
    </div>

    <div class="max-w-4xl space-y-6">
        <!-- Account Summary Banner -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col sm:flex-row items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white font-bold text-2xl flex items-center justify-center shadow-sm">
                {{ $user->initials }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold border {{ $user->role->badgeClasses() }}">
                        {{ $user->role->label() }}
                    </span>
                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold border {{ $user->status->badgeClasses() }}">
                        {{ $user->status->label() }}
                    </span>
                </div>
                <div class="text-xs text-slate-500 mt-1 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                    <span>✉ {{ $user->email }}</span>
                    @if($user->employee_id)
                        <span>• ID: {{ $user->employee_id }}</span>
                    @endif
                    @if($user->department)
                        <span>• 🏢 {{ $user->department->name }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profile Details Form -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                    Profile Information
                </h3>
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700">Full Name</label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name', $user->name) }}"
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-700">Official Phone / Extension</label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="designation" class="block text-xs font-semibold text-slate-700">Job Designation</label>
                        <input type="text" name="designation" id="designation"
                               value="{{ old('designation', $user->designation) }}"
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('designation') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500">Email Address (Read-only)</label>
                        <input type="text" disabled value="{{ $user->email }}"
                               class="mt-1 block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-xs text-slate-500 cursor-not-allowed">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex justify-center rounded-lg bg-slate-900 py-2 px-4 text-xs font-semibold text-white hover:bg-slate-800 transition">
                            Save Profile Details
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Update Form -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                    Update Security Password
                </h3>
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-xs font-semibold text-slate-700">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('current_password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-xs font-semibold text-slate-700">New Password</label>
                        <input type="password" name="password" id="new_password" required
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex justify-center rounded-lg bg-blue-600 py-2 px-4 text-xs font-semibold text-white hover:bg-blue-500 transition">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
