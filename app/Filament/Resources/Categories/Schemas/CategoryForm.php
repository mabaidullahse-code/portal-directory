<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Support\IconHelper;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('icon')
                    ->label('Icon')
                    ->searchable()
                    ->preload()
                    ->allowHtml()
                    ->options(IconHelper::getSelectOptions(allowHtml: true))
                    ->prefixIcon(fn (?string $state): ?string => IconHelper::toHeroicon($state))
                    ->helperText('Choose any system icon from the categorized dropdown or search by name.')
                    ->placeholder('Select an icon...'),

                Toggle::make('is_active')
                    ->label('Active Status')
                    ->default(true)
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Sort order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
