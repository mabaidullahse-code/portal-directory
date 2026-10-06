@php
    $user = auth()->user();
@endphp

<div class="space-y-6">
    @if ($user->isAdmin())
        <!-- Admin Navigation -->
        <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">
                Administration
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.users.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>User Management</span>
                </a>

                <a href="{{ route('admin.departments.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.departments.index') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.departments.index') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>Departments</span>
                </a>

                <a href="{{ route('admin.departments.import') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.departments.import') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.departments.import') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span>Import Departments</span>
                </a>
            </nav>
        </div>

        <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">
                Portal Management
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.portals.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.portals.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.portals.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span>All Portals</span>
                </a>

                <a href="{{ route('portals.create') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('portals.create') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('portals.create') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Register New Portal</span>
                </a>

                <a href="{{ route('directory.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('directory.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('directory.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Portal Directory</span>
                </a>

                <a href="{{ route('admin.settings.design') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.settings.design') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.settings.design') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    <span>Directory Design Settings</span>
                </a>
            </nav>
        </div>

        <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">
                Audits & Reports
            </div>
            <nav class="space-y-1">
                <a href="{{ route('reports.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('reports.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('reports.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Reports & Exports</span>
                </a>

                <a href="{{ route('admin.activity-logs.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.activity-logs.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.activity-logs.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Activity Audit Logs</span>
                </a>
            </nav>
        </div>

    @elseif ($user->isDirector())
        <!-- Director Navigation -->
        <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">
                Department Portal
            </div>
            <nav class="space-y-1">
                <a href="{{ route('director.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('director.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('director.dashboard') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Director Dashboard</span>
                </a>

                <a href="{{ route('director.my-portals') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('director.my-portals') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('director.my-portals') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>My Portals</span>
                </a>

                <a href="{{ route('director.employees') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('director.employees') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('director.employees') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Department Employees</span>
                </a>

                <a href="{{ route('director.department-portals') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('director.department-portals') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('director.department-portals') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span>Department Portals</span>
                </a>

                <a href="{{ route('portals.create') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('portals.create') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('portals.create') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Portal</span>
                </a>
            </nav>
        </div>

        <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">
                Overview & Reports
            </div>
            <nav class="space-y-1">
                <a href="{{ route('directory.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('directory.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('directory.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Portal Directory</span>
                </a>

                <a href="{{ route('reports.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('reports.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('reports.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Department Reports</span>
                </a>
            </nav>
        </div>

    @else
        <!-- Employee Navigation -->
        <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">
                Employee Workspace
            </div>
            <nav class="space-y-1">
                <a href="{{ route('employee.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('employee.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('employee.dashboard') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>My Dashboard</span>
                </a>

                <a href="{{ route('employee.portals.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('employee.portals.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('employee.portals.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>My Portals</span>
                </a>

                <a href="{{ route('portals.create') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('portals.create') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('portals.create') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Portal</span>
                </a>

                <a href="{{ route('directory.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('directory.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('directory.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Portal Directory</span>
                </a>
            </nav>
        </div>
    @endif

    <div>
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">
            Account
        </div>
        <nav class="space-y-1">
            <a href="{{ route('profile.show') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('profile.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('profile.*') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Profile Settings</span>
            </a>
        </nav>
    </div>
</div>
