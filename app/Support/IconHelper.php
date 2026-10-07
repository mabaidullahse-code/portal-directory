<?php

namespace App\Support;

use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class IconHelper
{
    /**
     * Curated primary icon groups for University & Enterprise Portal Directory.
     *
     * @return array<string, array<string, string>>
     */
    public static function getCuratedGroups(): array
    {
        return [
            'Academic & Education' => [
                'academic-cap' => 'Academic Cap (Degrees & Faculties)',
                'book-open' => 'Book Open (Library & Research)',
                'bookmark' => 'Bookmark (Registry & Marks)',
                'clipboard-document-check' => 'Clipboard Check (Examinations & Results)',
                'document-text' => 'Document Text (Circulars & Records)',
                'newspaper' => 'Newspaper (Press & Bulletins)',
                'pencil-square' => 'Pencil Square (Applications & Forms)',
                'presentation-chart-bar' => 'Presentation Bar (Lectures & Audits)',
                'queue-list' => 'Queue List (Course Catalogs & Rosters)',
                'beaker' => 'Beaker (Laboratories & Science)',
            ],
            'Human Resources & Personnel' => [
                'user-group' => 'User Group (HR & Staff Directory)',
                'user' => 'User (Individual Profile & Account)',
                'users' => 'Users (Community & Workforce)',
                'user-circle' => 'User Circle (Officer & Custodian)',
                'identification' => 'Identification (Official Badges & Biometrics)',
                'briefcase' => 'Briefcase (Employment & Corporate Affairs)',
                'building-office' => 'Building Office (Divisional Wing)',
                'building-office-2' => 'Building Office 2 (Headquarters & Blocks)',
            ],
            'Governance & Compliance' => [
                'building-library' => 'Building Library (Governance, Senate & Syndicate)',
                'scale' => 'Scale (Legal, Discipline & Ethics)',
                'shield-check' => 'Shield Check (Security, Quality & Compliance)',
                'shield-exclamation' => 'Shield Exclamation (Vulnerability & Alert)',
                'check-badge' => 'Check Badge (Accreditation & Certified Portals)',
                'flag' => 'Flag (Official Directives & Milestones)',
            ],
            'Finance & Procurement' => [
                'currency-dollar' => 'Currency Dollar (Finance, Accounts & Budget)',
                'banknotes' => 'Banknotes (Disbursements & Payroll)',
                'credit-card' => 'Credit Card (Online Fee Collection & Payments)',
                'calculator' => 'Calculator (Audit, Taxation & Estimates)',
                'receipt-percent' => 'Receipt Percent (Grants & Concessions)',
                'chart-bar' => 'Chart Bar (Financial Telemetry & Revenue)',
                'chart-pie' => 'Chart Pie (Budgetary Allocations)',
            ],
            'IT & Digital Infrastructure' => [
                'server-stack' => 'Server Stack (IT Datacenter & Cloud)',
                'computer-desktop' => 'Computer Desktop (Workstation & Portals)',
                'cpu-chip' => 'CPU Chip (Core Infrastructure & Compute)',
                'code-bracket' => 'Code Bracket (Developer APIs & Web Services)',
                'cloud' => 'Cloud (Cloud Storage & Data)',
                'circle-stack' => 'Circle Stack (Database & Registries)',
                'wifi' => 'Wi-Fi (Campus Network & Wireless)',
                'wrench-screwdriver' => 'Wrench & Screwdriver (IT Helpdesk & Repairs)',
                'command-line' => 'Command Line (Sysadmin Operations)',
                'signal' => 'Signal (Telecom & Network Coverage)',
                'window' => 'Window (Web Apps & Interfaces)',
                'device-phone-mobile' => 'Mobile Device (Campus Mobile Apps)',
            ],
            'Communication & Support' => [
                'envelope' => 'Envelope (Official Campus Email)',
                'chat-bubble-left-right' => 'Chat Bubbles (Helpdesk & Support)',
                'phone' => 'Phone (Telephone Directory & Helplines)',
                'megaphone' => 'Megaphone (Public Notices & Announcements)',
                'bell' => 'Bell (Alerts & Notifications)',
                'inbox' => 'Inbox (Incoming Submissions)',
                'lifebuoy' => 'Lifebuoy (Student Welfare & Assistance)',
            ],
            'Campus Facilities & Operations' => [
                'map-pin' => 'Map Pin (Campus Locations & Navigation)',
                'truck' => 'Truck (Transport & Logistics)',
                'home' => 'Home (Hostels & Accommodation)',
                'key' => 'Key (Access Control & Permissions)',
                'calendar-days' => 'Calendar Days (Academic Schedules & Events)',
                'clock' => 'Clock (Attendance & Shifts)',
                'globe-alt' => 'Globe Alt (Public Web & Global Portals)',
                'sparkles' => 'Sparkles (Innovation & Highlights)',
                'folder' => 'Folder (Archives & Documents)',
                'folder-open' => 'Folder Open (Active Dossiers)',
                'star' => 'Star (Featured Systems)',
                'trophy' => 'Trophy (Awards & Accolades)',
                'heart' => 'Heart (Medical Health Center)',
                'cog-6-tooth' => 'Cog (System Settings & Config)',
            ],
        ];
    }

    /**
     * Get all available icons categorized with HTML preview.
     *
     * @return array<string, array<string, string>>
     */
    public static function getSelectOptions(bool $allowHtml = true): array
    {
        $curated = self::getCuratedGroups();
        $usedKeys = [];
        $options = [];

        foreach ($curated as $groupName => $items) {
            $options[$groupName] = [];
            foreach ($items as $key => $label) {
                $usedKeys[$key] = true;
                $options[$groupName][$key] = $allowHtml
                    ? self::renderOptionHtml($key, $label)
                    : $label;
            }
        }

        // Collect all remaining Heroicons for maximum choice
        $otherIcons = [];
        foreach (Heroicon::cases() as $case) {
            $val = $case->value;
            $clean = str_starts_with($val, 'o-') ? substr($val, 2) : $val;

            if (! isset($usedKeys[$clean]) && ! isset($otherIcons[$clean])) {
                $otherIcons[$clean] = Str::headline($clean)." ({$clean})";
            }
        }

        ksort($otherIcons);

        if (! empty($otherIcons)) {
            $options['All Other Icons'] = [];
            foreach ($otherIcons as $key => $label) {
                $options['All Other Icons'][$key] = $allowHtml
                    ? self::renderOptionHtml($key, $label)
                    : $label;
            }
        }

        return $options;
    }

    /**
     * Render an option with SVG icon and descriptive label.
     */
    public static function renderOptionHtml(string $icon, string $label): string
    {
        $clean = str_replace(['heroicon-o-', 'o-'], '', $icon);
        $svgHtml = '';

        try {
            $svgObj = svg("heroicon-o-{$clean}", 'w-4 h-4', [
                'style' => 'width: 18px; height: 18px; display: inline-block; vertical-align: middle; flex-shrink: 0; margin-right: 6px;',
            ]);
            if ($svgObj) {
                $svgHtml = $svgObj->toHtml();
            }
        } catch (\Throwable) {
            $svgHtml = '<span style="display:inline-block;width:18px;text-align:center;font-size:12px;margin-right:6px;">🔹</span>';
        }

        return '<div style="display: flex; align-items: center; gap: 6px; padding: 2px 0;">'
            .$svgHtml
            .'<span style="font-weight: 500; font-size: 13px;">'.e($label).'</span>'
            .'</div>';
    }

    /**
     * Normalize an icon string to standard heroicon format for Filament.
     */
    public static function toHeroicon(?string $icon): ?string
    {
        if (blank($icon)) {
            return null;
        }

        $clean = str_replace(['heroicon-o-', 'o-'], '', trim($icon));

        return "heroicon-o-{$clean}";
    }
}
