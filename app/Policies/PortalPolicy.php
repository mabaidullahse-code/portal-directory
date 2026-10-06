<?php

namespace App\Policies;

use App\Models\Portal;
use App\Models\User;
use App\Services\PortalVisibilityService;

class PortalPolicy
{
    public function __construct(
        protected PortalVisibilityService $visibilityService
    ) {}

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Portal $portal): bool
    {
        return $this->visibilityService->canView($user, $portal);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Portal $portal): bool
    {
        return $this->visibilityService->canManage($user, $portal);
    }

    public function delete(User $user, Portal $portal): bool
    {
        return $this->visibilityService->canManage($user, $portal);
    }

    public function toggleStatus(User $user, Portal $portal): bool
    {
        return $this->visibilityService->canManage($user, $portal);
    }
}
