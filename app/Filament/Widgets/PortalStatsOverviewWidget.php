<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortalStatsOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $activePortals = Portal::active()->count();
        $totalPortals = Portal::count();
        $departmentsWithPortals = Department::active()->whereHas('portals', fn ($q) => $q->active())->count();
        $categoriesCount = Category::active()->count();
        $usersCount = User::active()->count();

        return [
            Stat::make('Active Portals', $activePortals)
                ->description("{$totalPortals} total systems registered")
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('success'),

            Stat::make('Active Departments', $departmentsWithPortals)
                ->description('Divisions with operational portals')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('System Categories', $categoriesCount)
                ->description('Enterprise classifications')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('info'),

            Stat::make('Registered Staff', $usersCount)
                ->description('Personnel & administrators')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
