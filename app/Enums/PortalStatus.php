<?php

namespace App\Enums;

enum PortalStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SCHEDULED = 'scheduled';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::SCHEDULED => 'Scheduled',
            self::EXPIRED => 'Expired',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/20',
            self::INACTIVE => 'bg-slate-100 text-slate-700 border-slate-200 ring-slate-600/20',
            self::SCHEDULED => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-600/20',
            self::EXPIRED => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-600/20',
        };
    }

    public function dotClasses(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-emerald-500',
            self::INACTIVE => 'bg-slate-400',
            self::SCHEDULED => 'bg-amber-500',
            self::EXPIRED => 'bg-rose-500',
        };
    }
}
