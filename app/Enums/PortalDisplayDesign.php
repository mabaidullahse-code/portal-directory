<?php

namespace App\Enums;

enum PortalDisplayDesign: string
{
    case CARD_GRID = 'card_grid';
    case EMPLOYEE_SECTIONS = 'employee_sections';
    case RADIAL = 'radial';
    case COMPACT = 'compact';
    case DASHBOARD = 'dashboard';

    public function label(): string
    {
        return match ($this) {
            self::CARD_GRID => 'Card Grid',
            self::EMPLOYEE_SECTIONS => 'Employee Sections',
            self::RADIAL => 'Department Radial',
            self::COMPACT => 'Compact Buttons',
            self::DASHBOARD => 'Modern Dashboard',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::CARD_GRID => 'Clean responsive grid of modern cards grouped by department and employees.',
            self::EMPLOYEE_SECTIONS => 'Structured employee roster rows with portal listings per person.',
            self::RADIAL => 'Interactive visualization centered around the department with radiating employee and portal nodes.',
            self::COMPACT => 'Dense list view with sleek launch buttons ideal for quick directory switching.',
            self::DASHBOARD => 'Executive showcase view featuring rich metadata, category tags, and direct launch badges.',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::CARD_GRID => 'squares-2x2',
            self::EMPLOYEE_SECTIONS => 'queue-list',
            self::RADIAL => 'sparkles',
            self::COMPACT => 'bars-3-bottom-left',
            self::DASHBOARD => 'rectangle-group',
        };
    }
}
