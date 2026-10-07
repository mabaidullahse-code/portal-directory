<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isDirector();
    }

    public function view(User $user, User $model): bool
    {
        if ($user->isAdmin() || $user->id === $model->id) {
            return true;
        }

        if ($user->isDirector()) {
            return $user->department_id && $model->department_id === $user->department_id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        if (! $user->isAdmin()) {
            return false;
        }

        // Cannot delete oneself
        return $user->id !== $model->id;
    }
}
