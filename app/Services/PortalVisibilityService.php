<?php

namespace App\Services;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

class PortalVisibilityService
{
    /**
     * Scope a portal query based on user role and department permissions.
     */
    public function applyVisibleScope(Builder|Relation $query, User $user): Builder|Relation
    {
        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isDirector()) {
            $departmentId = $user->department_id;
            return $query->where(function (Builder $q) use ($user, $departmentId) {
                if ($departmentId) {
                    $q->where('department_id', $departmentId);
                }
                $q->orWhere('user_id', $user->id)
                  ->orWhereHas('targetDepartments', function (Builder $tq) use ($departmentId) {
                      if ($departmentId) {
                          $tq->where('departments.id', $departmentId);
                      }
                  })
                  ->orWhereHas('targetUsers', function (Builder $uq) use ($user) {
                      $uq->where('users.id', $user->id);
                  });
            });
        }

        // Employee
        $departmentId = $user->department_id;
        return $query->where(function (Builder $q) use ($user, $departmentId) {
            $q->where('user_id', $user->id)
              ->orWhereHas('targetUsers', function (Builder $uq) use ($user) {
                  $uq->where('users.id', $user->id);
              });

            if ($departmentId) {
                $q->orWhereHas('targetDepartments', function (Builder $tq) use ($departmentId) {
                    $tq->where('departments.id', $departmentId);
                });
            }
        });
    }

    /**
     * Check if user can view a given portal.
     */
    public function canView(User $user, Portal $portal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($portal->user_id === $user->id) {
            return true;
        }

        if ($user->isDirector()) {
            if ($user->department_id && $portal->department_id === $user->department_id) {
                return true;
            }

            if ($user->department_id && $portal->targetDepartments()->where('departments.id', $user->department_id)->exists()) {
                return true;
            }

            return $portal->targetUsers()->where('users.id', $user->id)->exists();
        }

        // Employee
        if ($portal->targetUsers()->where('users.id', $user->id)->exists()) {
            return true;
        }

        if ($user->department_id && $portal->targetDepartments()->where('departments.id', $user->department_id)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Check if user can edit/delete/deactivate a given portal.
     */
    public function canManage(User $user, Portal $portal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Both Directors and Employees can manage their own portals
        return $portal->user_id === $user->id;
    }

    /**
     * Get grouped department data for Directory views.
     */
    public function getDirectoryTree(User $user, ?int $selectedDepartmentId = null, ?string $search = null): Collection
    {
        $deptQuery = Department::query()->active()->orderBy('name');

        if (!$user->isAdmin()) {
            // Directors and Employees are restricted to their department for directory overview,
            // or if selectedDepartmentId is provided, check permission
            if ($user->department_id) {
                $deptQuery->where('id', $user->department_id);
            }
        } elseif ($selectedDepartmentId) {
            $deptQuery->where('id', $selectedDepartmentId);
        }

        $departments = $deptQuery->with([
            'users' => function ($uQuery) use ($user, $search) {
                $uQuery->active()->with(['portals' => function ($pQuery) use ($user, $search) {
                    $this->applyVisibleScope($pQuery, $user);
                    $pQuery->active()->orderBy('sort_order')->orderBy('title');
                    if ($search) {
                        $pQuery->search($search);
                    }
                }]);
            }
        ])->get();

        // Filter out employees who have no portals if search is applied
        if ($search) {
            foreach ($departments as $dept) {
                $dept->setRelation('users', $dept->users->filter(fn($u) => $u->portals->isNotEmpty()));
            }
        }

        return $departments;
    }
}
