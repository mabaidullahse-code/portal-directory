<?php

namespace App\Filament\Resources\Portals\Schemas;

use App\Enums\PortalStatus;
use App\Support\IconHelper;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PortalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('System Endpoint & Essentials')
                    ->description('Core portal information, URL access endpoint, and categorization.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Portal Title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('Unique URL identifier (auto-generated if empty).')
                            ->maxLength(255),
                        TextInput::make('url')
                            ->label('Portal URL')
                            ->url()
                            ->required()
                            ->maxLength(2048)
                            ->placeholder('https://portal.example.org'),
                        TextInput::make('purpose')
                            ->label('Short Purpose')
                            ->placeholder('Quick summary for directory cards')
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Status')
                            ->options(PortalStatus::class)
                            ->default('active')
                            ->required(),
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('icon')
                            ->label('Icon')
                            ->searchable()
                            ->options(IconHelper::getSelectOptions(allowHtml: false))
                            ->prefixIcon(fn (?string $state): ?string => IconHelper::toHeroicon($state))
                            ->placeholder('Choose an icon...')
                            ->helperText('Select any system icon for this portal.'),
                        Textarea::make('description')
                            ->label('Detailed Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Target Department & Contact Information')
                    ->description('Target audience department and primary administrative contact.')
                    ->schema([
                        TextInput::make('target_department')
                            ->label('Target Department')
                            ->placeholder('e.g. Finance & Accounts / Academic Wing / Student Affairs')
                            ->helperText('Type any target department or audience (can differ from internal university departments).')
                            ->maxLength(255),
                        TextInput::make('contact_person')
                            ->label('Contact Person')
                            ->maxLength(150),
                        TextInput::make('contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->maxLength(150),
                        TextInput::make('contact_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(50),
                    ])
                    ->columns(2),

                Section::make('Operational & Scheduling Parameters')
                    ->description('Opening/closing dates, versioning, and sort ordering.')
                    ->schema([
                        DatePicker::make('opening_date')
                            ->label('Opening Date'),
                        DatePicker::make('closing_date')
                            ->label('Closing Date'),
                        TextInput::make('version')
                            ->label('System Version')
                            ->placeholder('e.g. v2.4.1')
                            ->maxLength(50),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Comma-separated tags')
                            ->columnSpanFull(),
                        Textarea::make('remarks')
                            ->label('Administrative Remarks')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
