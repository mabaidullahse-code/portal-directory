<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PortalVisibilityService
{
    /**
     * Scope a portal query based on user role and department permissions.
     */
    public function applyVisibleScope(Builder|Relation $query, User $user): Builder|Relation
    {
        if ($user->isAdmin() || $user->isVc()) {
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
        if ($user->isAdmin() || $user->isVc()) {
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

        // VC is executive read-only, cannot edit/delete portals
        if ($user->isVc()) {
            return false;
        }

        // Both Directors and Employees can manage their own portals
        return $portal->user_id === $user->id;
    }

    /**
     * Get grouped department data for Directory views.
     */
    public function getDirectoryTree(?User $user = null, string|int|null $selectedDepartmentId = null, ?string $search = null, string|int|null $categoryId = null): Collection
    {
        $user = $user ?? (Auth::user() ?? new User(['role' => UserRole::VC]));
        $portalQuery = Portal::query()->active()->with(['user.department', 'department', 'category', 'targetDepartments']);
        $this->applyVisibleScope($portalQuery, $user);

        if ($search) {
            $portalQuery->search($search);
        }

        if ($categoryId && $categoryId !== 'all') {
            $portalQuery->where('category_id', (int) $categoryId);
        }

        if ($selectedDepartmentId && $selectedDepartmentId !== 'all') {
            if (is_string($selectedDepartmentId) && str_starts_with($selectedDepartmentId, 'target:')) {
                $targetName = substr($selectedDepartmentId, 7);
                $portalQuery->where('target_department', $targetName);
            } else {
                $portalQuery->where('department_id', (int) $selectedDepartmentId);
            }
        }

        $allPortals = $portalQuery->orderBy('sort_order')->orderBy('title')->get();
        $realDepartments = Department::active()->orderBy('name')->get()->keyBy('id');

        $grouped = [];

        foreach ($allPortals as $portal) {
            $deptKey = null;
            $deptModel = null;

            if ($portal->department_id && isset($realDepartments[$portal->department_id])) {
                $deptKey = 'dept_'.$portal->department_id;
                $deptModel = $realDepartments[$portal->department_id];
            } elseif ($portal->target_department) {
                $deptKey = 'target_'.Str::slug($portal->target_department);
                $code = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $portal->target_department), 0, 4)) ?: 'TGT';
                $deptModel = new Department([
                    'name' => $portal->target_department,
                    'short_name' => $portal->target_department,
                    'code' => $code,
                    'status' => 'active',
                ]);
                $deptModel->id = abs(crc32($portal->target_department));
            } elseif ($portal->user?->department_id && isset($realDepartments[$portal->user->department_id])) {
                $deptKey = 'dept_'.$portal->user->department_id;
                $deptModel = $realDepartments[$portal->user->department_id];
            } else {
                $deptKey = 'universal';
                $deptModel = new Department([
                    'name' => 'General & Universal Systems',
                    'short_name' => 'Universal',
                    'code' => 'UNIV',
                    'status' => 'active',
                ]);
                $deptModel->id = 0;
            }

            // Permission scoping for director/employee
            if (! $user->isAdmin() && ! $user->isVc() && $user->department_id) {
                if ($portal->department_id && $portal->department_id !== $user->department_id) {
                    continue;
                }
            }

            if (! isset($grouped[$deptKey])) {
                $deptClone = clone $deptModel;
                $deptClone->setRelation('users', collect());
                $grouped[$deptKey] = [
                    'dept' => $deptClone,
                    'users_map' => [],
                ];
            }

            $creator = $portal->user ?: new User([
                'name' => $portal->contact_person ?: 'System Administrator',
                'designation' => 'Portal Custodian',
            ]);
            $uId = $creator->id ?? ('portal_'.$portal->id);

            if (! isset($grouped[$deptKey]['users_map'][$uId])) {
                $userClone = clone $creator;
                $userClone->setRelation('portals', collect());
                $grouped[$deptKey]['users_map'][$uId] = $userClone;
            }

            $grouped[$deptKey]['users_map'][$uId]->portals->push($portal);
        }

        $result = collect();
        foreach ($grouped as $item) {
            $dept = $item['dept'];
            $usersCollection = collect(array_values($item['users_map']));
            $dept->setRelation('users', $usersCollection);
            $result->push($dept);
        }

        return $result;
    }
}
