<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case VC = 'vc';
    case DIRECTOR = 'director';
    case EMPLOYEE = 'employee';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::VC => 'Vice Chancellor',
            self::DIRECTOR => 'Director',
            self::EMPLOYEE => 'Employee',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::ADMIN => 'bg-purple-100 text-purple-800 border-purple-200',
            self::VC => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            self::DIRECTOR => 'bg-blue-100 text-blue-800 border-blue-200',
            self::EMPLOYEE => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        };
    }
}
