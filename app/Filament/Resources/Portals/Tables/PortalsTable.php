<?php

namespace App\Filament\Resources\Portals\Tables;

use App\Enums\PortalStatus;
use App\Models\Portal;
use App\Services\PortalVisibilityService;
use App\Support\IconHelper;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PortalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Portal Title')
                    ->icon(fn (Portal $record): ?string => IconHelper::toHeroicon($record->icon) ?? IconHelper::toHeroicon($record->category?->icon))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Portal $record): ?string => $record->purpose),

                TextColumn::make('target_department')
                    ->label('Target Department')
                    ->state(fn (Portal $record): string => $record->target_department ?: ($record->department?->name ?? '—'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Managed By')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state instanceof PortalStatus ? $state->value : (string) $state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'draft' => 'warning',
                        'archived' => 'danger',
                        default => 'info',
                    })
                    ->sortable(),

                TextColumn::make('computed_status')
                    ->label('Schedule Status')
                    ->badge()
                    ->state(fn (Portal $record): string => $record->computed_status->label())
                    ->color(fn (Portal $record) => match ($record->computed_status->value) {
                        'active' => 'success',
                        'scheduled' => 'warning',
                        'expired' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('safe_url')
                    ->label('URL')
                    ->copyable()
                    ->limit(28)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(),

                SelectFilter::make('status')
                    ->options(PortalStatus::class)
                    ->label('Status'),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('Open Portal')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('primary')
                    ->url(fn (Portal $record): string => $record->safe_url, shouldOpenInNewTab: true),

                ViewAction::make(),

                EditAction::make()
                    ->visible(fn (Portal $record): bool => ! auth()->user()?->isVc() && app(PortalVisibilityService::class)->canManage(auth()->user(), $record)),

                DeleteAction::make()
                    ->visible(fn (Portal $record): bool => ! auth()->user()?->isVc() && app(PortalVisibilityService::class)->canManage(auth()->user(), $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->isAdmin()),
                ]),
            ]);
    }
}
