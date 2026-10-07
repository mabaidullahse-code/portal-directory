<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Initiating User')
                    ->searchable()
                    ->sortable()
                    ->placeholder('System / Automated'),

                TextColumn::make('action')
                    ->label('Event / Action')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Details')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->fontFamily('mono'),

                TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
