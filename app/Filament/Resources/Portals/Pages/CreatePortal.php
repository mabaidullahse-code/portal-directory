<?php

namespace App\Filament\Resources\Portals\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\Portals\PortalResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreatePortal extends CreateRecord
{
    protected static string $resource = PortalResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id() ?? User::where('role', UserRole::ADMIN)->first()?->id ?? 1;

        return $data;
    }
}
