<?php

namespace App\Enums;

enum PortalDisplayDesign: string
{
    case CARD_GRID = 'card_grid';
    case EMPLOYEE_SECTIONS = 'employee_sections';
    case RADIAL = 'radial';
    case COMPACT = 'compact';
    case DASHBOARD = 'dashboard';
    case CYBER_MATRIX = 'cyber_matrix';
    case CONSTELLATION = 'constellation';
    case PRISM_BENTO = 'prism_bento';
    case TERMINAL_CONSOLE = 'terminal_console';

    public function label(): string
    {
        return match ($this) {
            self::CARD_GRID => 'Card Grid',
            self::EMPLOYEE_SECTIONS => 'Employee Sections',
            self::RADIAL => 'Department Radial',
            self::COMPACT => 'Compact Buttons',
            self::DASHBOARD => 'Modern Dashboard',
            self::CYBER_MATRIX => 'Cyber Matrix HUD',
            self::CONSTELLATION => 'Orbital Starfield Deck',
            self::PRISM_BENTO => 'Holographic Prism Bento',
            self::TERMINAL_CONSOLE => 'Mission Control Terminal',
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
            self::CYBER_MATRIX => 'Futuristic cyberpunk HUD telemetry grid with neon targeting brackets, diagnostics, and high-frequency portal uplinks.',
            self::CONSTELLATION => 'Deep-space galactic command deck with floating celestial nodes, stellar orbit paths, and gravity warp launch buttons.',
            self::PRISM_BENTO => 'Next-gen translucent glassmorphic bento system with specular iridescent highlights, interactive 3D tilt, and telemetry meters.',
            self::TERMINAL_CONSOLE => 'Aerospace mission control console with monospace telemetry feeds, live signal indicators, and rapid launch matrices.',
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
            self::CYBER_MATRIX => 'cpu-chip',
            self::CONSTELLATION => 'globe-alt',
            self::PRISM_BENTO => 'swatch',
            self::TERMINAL_CONSOLE => 'command-line',
        };
    }
}
