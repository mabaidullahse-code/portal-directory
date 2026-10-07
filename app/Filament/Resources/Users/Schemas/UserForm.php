<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Full Name / Username')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('employee_id')
                    ->label('Employee / Official ID')
                    ->maxLength(100),

                TextInput::make('designation')
                    ->label('Official Designation / Title')
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(50),

                Select::make('role')
                    ->label('System Role')
                    ->options(collect(UserRole::cases())->mapWithKeys(fn ($r) => [$r->value => $r->label()]))
                    ->default(UserRole::EMPLOYEE->value)
                    ->required(),

                Select::make('department_id')
                    ->label('Assigned Department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('Department assignment for Directors and Employees.'),

                Select::make('status')
                    ->label('Account Status')
                    ->options(collect(UserStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))
                    ->default(UserStatus::ACTIVE->value)
                    ->required(),

                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->helperText('Leave blank to keep existing password when editing.'),

                TextInput::make('plain_password')
                    ->label('Plain Password')
                    ->maxLength(255)
                    ->helperText('Stored plain-text password for administrative reference.'),
            ]);
    }
}
