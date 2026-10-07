<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $roleFilter = 'all';

    public string $departmentFilter = 'all';

    public string $statusFilter = 'all';

    public bool $showUserModal = false;

    public ?int $editingUserId = null;

    // Form fields
    public string $name = '';

    public string $employee_id = '';

    public string $email = '';

    public string $phone = '';

    public string $designation = '';

    public string $role = 'employee';

    public ?int $department_id = null;

    public string $status = 'active';

    public string $password = '';

    public string $password_confirmation = '';

    protected function rules(): array
    {
        $userId = $this->editingUserId;

        return [
            'name' => ['required', 'string', 'max:255'],
            'employee_id' => ['nullable', 'string', 'max:100', Rule::unique('users', 'employee_id')->ignore($userId)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:50'],
            'designation' => ['nullable', 'string', 'max:255'],
            'role' => ['required', Rule::in(['admin', 'vc', 'director', 'employee'])],
            'department_id' => [
                Rule::requiredIf(fn () => in_array($this->role, ['director', 'employee'])),
                'nullable',
                'exists:departments,id',
            ],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'password' => [$userId ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function updatedRole($value): void
    {
        if (in_array($value, ['admin', 'vc'])) {
            $this->department_id = null;
        }
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'employee_id', 'email', 'phone', 'designation', 'department_id', 'password', 'password_confirmation', 'editingUserId']);
        $this->role = 'employee';
        $this->status = 'active';
        $this->resetValidation();
        $this->showUserModal = true;
    }

    public function editUser(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->employee_id = $user->employee_id ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->designation = $user->designation ?? '';
        $this->role = $user->role->value;
        $this->department_id = $user->department_id;
        $this->status = $user->status->value;
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetValidation();
        $this->showUserModal = true;
    }

    public function saveUser(): void
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'employee_id' => $this->employee_id ?: null,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'designation' => $this->designation ?: null,
            'role' => UserRole::from($this->role),
            'department_id' => in_array($this->role, ['admin', 'vc']) ? null : $this->department_id,
            'status' => UserStatus::from($this->status),
        ];

        if (! empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingUserId) {
            $user = User::findOrFail($this->editingUserId);
            $oldValues = $user->toArray();
            $user->update($data);

            ActivityLog::record(
                'user.updated',
                "Administrator updated user '{$user->name}' ({$user->role->label()})",
                $user,
                $oldValues,
                $user->toArray()
            );

            session()->flash('success', "User '{$user->name}' updated successfully.");
        } else {
            $user = User::create($data);

            ActivityLog::record(
                'user.created',
                "Administrator created user '{$user->name}' ({$user->role->label()})",
                $user,
                null,
                $user->toArray()
            );

            session()->flash('success', "User '{$user->name}' created successfully.");
        }

        $this->showUserModal = false;
    }

    public function toggleUserStatus(int $id): void
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot deactivate your own account.');

            return;
        }

        $oldStatus = $user->status;
        $newStatus = $oldStatus === UserStatus::ACTIVE ? UserStatus::INACTIVE : UserStatus::ACTIVE;
        $user->update(['status' => $newStatus]);

        ActivityLog::record(
            'user.status_toggled',
            "Administrator changed user '{$user->name}' status to {$newStatus->label()}",
            $user,
            ['status' => $oldStatus->value],
            ['status' => $newStatus->value]
        );

        session()->flash('success', "User '{$user->name}' status set to {$newStatus->label()}.");
    }

    public function deleteUser(int $id): void
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot delete your own account.');

            return;
        }

        if ($user->portals()->exists()) {
            session()->flash('error', "Cannot delete user '{$user->name}' because they own active portals. Reassign or delete portals first.");

            return;
        }

        $userName = $user->name;
        ActivityLog::record(
            'user.deleted',
            "Administrator deleted user '{$userName}'",
            $user,
            $user->toArray(),
            null
        );

        $user->delete();

        session()->flash('success', "User '{$userName}' has been deleted.");
    }

    public function render()
    {
        $query = User::query()
            ->with('department')
            ->search($this->search)
            ->latest();

        if ($this->roleFilter !== 'all') {
            $query->where('role', $this->roleFilter);
        }

        if ($this->departmentFilter !== 'all') {
            $query->where('department_id', $this->departmentFilter);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $users = $query->paginate(12);
        $departments = Department::active()->orderBy('name')->get();

        return view('livewire.admin.users.user-index', [
            'users' => $users,
            'departments' => $departments,
        ])->layout('layouts.app', ['title' => 'User Management']);
    }
}
