<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ $organization_name }}</title>
    <style>
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --border-hover: #cbd5e1;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
            --success-border: #a7f3d0;
            --gray-bg: #f1f5f9;
            --gray-text: #475569;
            --gray-border: #cbd5e1;
            --warning-bg: #fffbeb;
            --warning-text: #92400e;
            --warning-border: #fde68a;
            --danger-bg: #fef2f2;
            --danger-text: #991b1b;
            --danger-border: #fecaca;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            line-height: 1.5;
            padding: 32px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header.report-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            border-radius: 12px;
            padding: 28px 36px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .org-badge {
            display: inline-block;
            background: rgba(37, 99, 235, 0.25);
            color: #93c5fd;
            border: 1px solid rgba(147, 197, 253, 0.3);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .report-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .report-meta {
            font-size: 12px;
            color: #cbd5e1;
            text-align: right;
        }

        .report-meta strong {
            color: #ffffff;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            padding: 12px 16px;
            text-align: center;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
        }

        .stat-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .search-bar {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .search-bar input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 14px;
            color: var(--text-main);
        }

        .dept-section {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 28px;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .dept-header {
            background: #f1f5f9;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .dept-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dept-code {
            background: #e2e8f0;
            color: #334155;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .dept-content {
            padding: 24px;
        }

        .emp-block {
            margin-bottom: 24px;
        }

        .emp-block:last-child {
            margin-bottom: 0;
        }

        .emp-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            margin-bottom: 14px;
            border-bottom: 2px solid #e2e8f0;
        }

        .emp-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .emp-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #2563eb;
            color: #ffffff;
            font-weight: 700;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .emp-name {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }

        .emp-role {
            font-size: 11px;
            color: var(--text-muted);
        }

        .portal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 16px;
        }

        .portal-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .portal-card:hover {
            transform: translateY(-2px);
            border-color: var(--border-hover);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 8px;
        }

        .portal-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
        }

        .portal-category {
            display: inline-block;
            font-size: 10px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .portal-purpose {
            font-size: 12px;
            color: #475569;
            margin-bottom: 14px;
            flex-grow: 1;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 700;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-active {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid var(--success-border);
        }

        .badge-inactive {
            background: var(--gray-bg);
            color: var(--gray-text);
            border: 1px solid var(--gray-border);
        }

        .badge-scheduled {
            background: var(--warning-bg);
            color: var(--warning-text);
            border: 1px solid var(--warning-border);
        }

        .badge-expired {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid var(--danger-border);
        }

        .card-bottom {
            border-top: 1px solid #f1f5f9;
            padding-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .launch-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #2563eb;
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .launch-btn:hover {
            background: #1d4ed8;
        }

        .card-meta {
            font-size: 10px;
            color: var(--text-muted);
        }

        footer.report-footer {
            text-align: center;
            padding: 24px 0 12px 0;
            font-size: 11px;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            margin-top: 32px;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .search-bar, .launch-btn {
                display: none;
            }
            .dept-section {
                box-shadow: none;
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="report-header">
            <div class="header-top">
                <div>
                    <div class="org-badge">{{ $organization_name }}</div>
                    <h1 class="report-title">Portal Directory & Inventory Report</h1>
                </div>
                <div class="report-meta">
                    <div><strong>Department Scope:</strong> {{ $department_scope }}</div>
                    <div><strong>Generated By:</strong> {{ $generated_by->name }} ({{ $generated_by->role->label() }})</div>
                    <div><strong>Report Date:</strong> {{ $generated_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $summary['total_portals'] }}</div>
                    <div class="stat-label">Total Portals</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $summary['active_portals'] }}</div>
                    <div class="stat-label">Active Portals</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $summary['inactive_portals'] }}</div>
                    <div class="stat-label">Inactive Portals</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $summary['total_departments'] }}</div>
                    <div class="stat-label">Departments</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $summary['total_employees'] }}</div>
                    <div class="stat-label">Employees</div>
                </div>
            </div>
        </header>

        <div class="search-bar">
            <span>🔍</span>
            <input type="text" id="filterInput" placeholder="Quick filter portals by title, description, or employee name..." onkeyup="filterReport()">
        </div>

        <div id="reportContent">
            @forelse($departments as $deptData)
                <section class="dept-section" data-dept="{{ strtolower($deptData['department']->name) }}">
                    <div class="dept-header">
                        <div class="dept-title">
                            <span>🏢 {{ $deptData['department']->name }}</span>
                            <span class="dept-code">{{ $deptData['department']->code }}</span>
                        </div>
                        <div class="card-meta">
                            {{ $deptData['total_portals'] }} Portals ({{ $deptData['active_portals'] }} Active)
                        </div>
                    </div>

                    <div class="dept-content">
                        @foreach($deptData['employees'] as $empData)
                            <div class="emp-block" data-employee="{{ strtolower($empData['employee']->name) }}">
                                <div class="emp-banner">
                                    <div class="emp-info">
                                        <div class="emp-avatar">
                                            {{ $empData['employee']->initials }}
                                        </div>
                                        <div>
                                            <div class="emp-name">{{ $empData['employee']->name }}</div>
                                            <div class="emp-role">
                                                {{ $empData['employee']->designation ?: $empData['employee']->role->label() }}
                                                @if($empData['employee']->employee_id)
                                                    • ID: {{ $empData['employee']->employee_id }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-meta">
                                        {{ $empData['total'] }} Portal(s)
                                    </div>
                                </div>

                                <div class="portal-grid">
                                    @foreach($empData['portals'] as $portal)
                                        @php
                                            $compStatus = $portal->computed_status;
                                        @endphp
                                        <div class="portal-card" data-portal-card>
                                            <div>
                                                <div class="card-top">
                                                    <h3 class="portal-title">{{ $portal->title }}</h3>
                                                    <span class="badge badge-{{ $compStatus->value }}">
                                                        {{ $compStatus->label() }}
                                                    </span>
                                                </div>

                                                @if($portal->category)
                                                    <div class="portal-category">📁 {{ $portal->category->name }}</div>
                                                @endif

                                                <p class="portal-purpose">
                                                    {{ $portal->purpose ?: $portal->description ?: 'No description provided.' }}
                                                </p>
                                            </div>

                                            <div class="card-bottom">
                                                <div class="card-meta">
                                                    @if($portal->opening_date)
                                                        <div>Open: {{ $portal->opening_date->format('d M Y') }}</div>
                                                    @endif
                                                    @if($portal->closing_date)
                                                        <div>Close: {{ $portal->closing_date->format('d M Y') }}</div>
                                                    @endif
                                                </div>

                                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer" class="launch-btn">
                                                    Open Portal ↗
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @empty
                <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 8px; padding: 48px; text-align: center; color: var(--text-muted);">
                    No portals found for this report scope.
                </div>
            @endforelse
        </div>

        <footer class="report-footer">
            <p>Official Standalone Report Generated by {{ $organization_name }} Portal System</p>
            <p>Generated: {{ $generated_at->toRfc2822String() }} • Completely Standalone & Offline Ready</p>
        </footer>
    </div>

    <script>
        function filterReport() {
            const query = document.getElementById('filterInput').value.toLowerCase();
            const cards = document.querySelectorAll('[data-portal-card]');
            
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                const parentEmp = card.closest('.emp-block');
                const empText = parentEmp ? parentEmp.getAttribute('data-employee') : '';
                
                if (text.includes(query) || empText.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            // Hide employee blocks if all cards hidden
            document.querySelectorAll('.emp-block').forEach(emp => {
                const visibleCards = emp.querySelectorAll('[data-portal-card][style="display: flex;"]');
                const allCards = emp.querySelectorAll('[data-portal-card]');
                if (query.trim() === '') {
                    emp.style.display = 'block';
                    allCards.forEach(c => c.style.display = 'flex');
                } else if (visibleCards.length === 0) {
                    emp.style.display = 'none';
                } else {
                    emp.style.display = 'block';
                }
            });
        }
    </script>
</body>
</html>
