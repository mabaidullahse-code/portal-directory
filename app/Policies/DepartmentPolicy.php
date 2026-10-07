<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;

class DepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Department $department): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->department_id === $department->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Department $department): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Department $department): bool
    {
        if (! $user->isAdmin()) {
            return false;
        }

        // Do not allow department deletion if users or portals depend on it
        if ($department->users()->exists() || $department->portals()->exists()) {
            return false;
        }

        return true;
    }
}
