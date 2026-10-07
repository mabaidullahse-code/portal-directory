<?php

namespace App\Filament\Resources\Portals;

use App\Filament\Resources\Portals\Pages\CreatePortal;
use App\Filament\Resources\Portals\Pages\EditPortal;
use App\Filament\Resources\Portals\Pages\ListPortals;
use App\Filament\Resources\Portals\Schemas\PortalForm;
use App\Filament\Resources\Portals\Tables\PortalsTable;
use App\Models\Portal;
use App\Services\PortalVisibilityService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PortalResource extends Resource
{
    protected static ?string $model = Portal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations & Portals';

    protected static ?string $navigationLabel = 'Portals Inventory';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        $user = auth()->user();

        return $user && ! $user->isVc();
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        if (! $user || $user->isVc()) {
            return false;
        }

        return app(PortalVisibilityService::class)->canManage($user, $record);
    }

    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();
        if (! $user || $user->isVc()) {
            return false;
        }

        return app(PortalVisibilityService::class)->canManage($user, $record);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        return app(PortalVisibilityService::class)->applyVisibleScope($query, $user);
    }

    public static function form(Schema $schema): Schema
    {
        return PortalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPortals::route('/'),
            'create' => CreatePortal::route('/create'),
            'edit' => EditPortal::route('/{record}/edit'),
        ];
    }
}
