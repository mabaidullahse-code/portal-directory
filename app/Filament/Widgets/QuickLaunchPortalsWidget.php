<?php

namespace App\Filament\Widgets;

use App\Models\Portal;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class QuickLaunchPortalsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Quick Portal Launch Pad';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Portal::query()->active()->with(['department', 'category'])->orderBy('sort_order')->orderBy('title'))
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('title')
                    ->label('Portal Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Portal $record): ?string => $record->purpose),

                TextColumn::make('department.name')
                    ->label('Department')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color('success'),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('Open Portal')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('primary')
                    ->url(fn (Portal $record): string => $record->safe_url, shouldOpenInNewTab: true),
            ]);
    }
}
