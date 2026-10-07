<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (filled($data['password'] ?? null) && empty($data['plain_password'] ?? null)) {
            $data['plain_password'] = $data['password'];
        } elseif (filled($data['plain_password'] ?? null) && empty($data['password'] ?? null)) {
            $data['password'] = bcrypt($data['plain_password']);
        }

        return $data;
    }
}
