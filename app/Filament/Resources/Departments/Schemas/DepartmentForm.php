<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Department Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('short_name')
                    ->label('Short Name / Acronym')
                    ->maxLength(50),

                TextInput::make('code')
                    ->label('Official Department Code')
                    ->required()
                    ->maxLength(20),

                Textarea::make('description')
                    ->label('Description & Scope')
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Department Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
