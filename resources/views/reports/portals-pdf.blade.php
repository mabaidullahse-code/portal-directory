<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }} - {{ $organization_name }}</title>
    <style>
        @page {
            margin: 28px 32px 38px 32px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .org-name {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .report-subtitle {
            font-size: 13px;
            font-weight: 600;
            color: #2563eb;
            margin-top: 3px;
        }
        .meta-text {
            font-size: 10px;
            color: #64748b;
            text-align: right;
        }
        .summary-table {
            width: 100%;
            margin-bottom: 18px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px 12px;
            text-align: center;
            border-right: 1px solid #e2e8f0;
        }
        .summary-table td:last-child {
            border-right: none;
        }
        .summary-val {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }
        .summary-lbl {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            margin-top: 2px;
            letter-spacing: 0.5px;
        }
        .dept-banner {
            background-color: #0f172a;
            color: #ffffff;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 3px;
            margin-top: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .emp-heading {
            font-size: 11px;
            font-weight: bold;
            color: #1e3a8a;
            background-color: #eff6ff;
            padding: 5px 10px;
            border-left: 3px solid #2563eb;
            margin-top: 10px;
            margin-bottom: 6px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .data-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 6px 8px;
            text-align: left;
            border: 1px solid #cbd5e1;
        }
        .data-table td {
            padding: 6px 8px;
            font-size: 10px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: 700;
            border-radius: 3px;
            text-transform: uppercase;
        }
        .badge-active {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .badge-inactive {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }
        .badge-scheduled {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fcd34d;
        }
        .badge-expired {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        .portal-url {
            color: #2563eb;
            text-decoration: underline;
            word-break: break-all;
            font-size: 9px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="footer">
        Confidential Enterprise Document • {{ $organization_name }} • Generated on {{ $generated_at->format('d M Y, h:i A') }}
    </div>

    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="org-name">{{ $organization_name }}</div>
                <div class="report-subtitle">PORTAL DIRECTORY DIRECTIVE & INVENTORY REPORT</div>
            </td>
            <td class="meta-text" style="vertical-align: middle;">
                <div><strong>Scope:</strong> {{ $department_scope }}</div>
                <div><strong>Generated By:</strong> {{ $generated_by->name }} ({{ $generated_by->role->label() }})</div>
                <div><strong>Date:</strong> {{ $generated_at->format('F d, Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-val">{{ $summary['total_portals'] }}</div>
                <div class="summary-lbl">Total Portals</div>
            </td>
            <td>
                <div class="summary-val" style="color: #15803d;">{{ $summary['active_portals'] }}</div>
                <div class="summary-lbl">Active</div>
            </td>
            <td>
                <div class="summary-val" style="color: #64748b;">{{ $summary['inactive_portals'] }}</div>
                <div class="summary-lbl">Inactive</div>
            </td>
            <td>
                <div class="summary-val">{{ $summary['total_departments'] }}</div>
                <div class="summary-lbl">Departments</div>
            </td>
            <td>
                <div class="summary-val">{{ $summary['total_employees'] }}</div>
                <div class="summary-lbl">Employees</div>
            </td>
        </tr>
    </table>

    @forelse($departments as $deptData)
        <div class="dept-banner">
            {{ $deptData['department']->name }} ({{ $deptData['department']->code }}) — {{ $deptData['total_portals'] }} Portals
        </div>

        @foreach($deptData['employees'] as $empData)
            <div class="emp-heading">
                👤 {{ $empData['employee']->name }}
                @if($empData['employee']->designation)
                    <span style="font-weight: normal; color: #475569;">— {{ $empData['employee']->designation }}</span>
                @endif
                <span style="float: right; font-weight: normal;">{{ $empData['total'] }} portal(s)</span>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">Portal Title & Category</th>
                        <th style="width: 30%;">Purpose & Description</th>
                        <th style="width: 25%;">Access URL</th>
                        <th style="width: 15%;">Status & Dates</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empData['portals'] as $idx => $portal)
                        <tr>
                            <td style="text-align: center; color: #64748b;">{{ $idx + 1 }}</td>
                            <td>
                                <strong>{{ $portal->title }}</strong>
                                @if($portal->category)
                                    <div style="font-size: 8px; color: #64748b; margin-top: 2px;">
                                        Category: {{ $portal->category->name }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $portal->purpose ?: '—' }}</div>
                                @if($portal->description && $portal->description !== $portal->purpose)
                                    <div style="font-size: 8.5px; color: #64748b; margin-top: 2px;">
                                        {{ Str::limit($portal->description, 100) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $portal->safe_url }}" class="portal-url" target="_blank">{{ $portal->safe_url }}</a>
                                @if($portal->contact_person || $portal->contact_email)
                                    <div style="font-size: 8px; color: #64748b; margin-top: 2px;">
                                        Contact: {{ $portal->contact_person }} ({{ $portal->contact_email }})
                                    </div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $computed = $portal->computed_status;
                                @endphp
                                <span class="badge badge-{{ $computed->value }}">
                                    {{ $computed->label() }}
                                </span>
                                @if($portal->opening_date)
                                    <div style="font-size: 8px; color: #64748b; margin-top: 3px;">
                                        Open: {{ $portal->opening_date->format('d/m/Y') }}
                                    </div>
                                @endif
                                @if($portal->closing_date)
                                    <div style="font-size: 8px; color: #64748b;">
                                        Close: {{ $portal->closing_date->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @empty
        <div style="text-align: center; padding: 24px; color: #64748b; border: 1px dashed #cbd5e1;">
            No portals found matching the selected report criteria.
        </div>
    @endforelse
</body>
</html>
