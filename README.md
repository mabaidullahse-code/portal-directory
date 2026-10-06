# Modern Laravel Portal Directory & Employee Management System

A production-ready, enterprise-grade organizational portal directory and employee management system built with **PHP 8.4**, **Laravel 13**, **Livewire 4**, **Tailwind CSS v4**, and **MySQL/MariaDB**.

---

## 🌟 Key Features

### 1. Role-Based & Department-Based Access Control (RBAC & DBAC)
- **Administrator**: Full organization-wide management (Users, Departments, Portals, Directory Architecture Settings, Activity Logs, All Reports).
- **Director**: Scoped strictly to their designated department. Can supervise department employees, view department portals, manage own portals, and export department-scoped reports. Cannot view or access other departments' employee/portal records.
- **Employee**: Can view profile, register and manage own portals with automatic department binding, view systems targeted to their department/role, and browse the directory.

### 2. Five Dynamic Portal Directory Architectures
Admins can select from 5 distinct visual presentation designs, complete with a **real-time interactive Live Preview**:
1. **Card Grid**: Clean responsive grid of cards grouped by department and employees.
2. **Employee Sections**: Structured roster rows with grouped portal systems per employee.
3. **Department Radial Architecture**: High-impact interactive radial visualization with glowing central department hub and radiating employee and portal nodes.
4. **Compact Buttons Directory**: Ultra-dense list view with status-indicator launch buttons.
5. **Modern Dashboard**: Showcase cards with category badges, schedule windows, target audience chips, and direct launch buttons.
- Global Directory Table View with instant search.

### 3. Automated Department & Ownership Assignment
- Employees never manually pick their department when creating portals — it is automatically derived and persisted from the authenticated employee's profile.
- Administrators can optionally choose owners with automatic departmental alignment.

### 4. Excel & CSV Department Import
- Bulk department uploads supporting `.xlsx`, `.xls`, and `.csv`.
- Two-stage workflow: **Upload & Parse** ➔ **Validation Analysis (Valid vs Duplicate / Errors)** ➔ **Safe Transactional Import** with full audit logging.
- Includes 1-click sample CSV template generator.

### 5. Multi-Format Enterprise Reporting
- **Official PDF Reports**: Formatted with organization headers, departmental scopes, summary metrics, employee grouping, and clickable URLs using DomPDF.
- **Standalone Offline HTML Reports**: 100% self-contained single-file HTML reports with embedded CSS, metrics cards, and client-side filtering that work offline in any browser without requiring Laravel.

### 6. Security & Audit Logging
- Server-side validation, authorization policies, and middleware guards.
- URL safety sanitizer preventing malicious protocols (e.g. `javascript:`, `data:`).
- Immutable audit log capturing Who, What, When, IP Address, and JSON diffs of previous vs updated values.

---

## 💻 Tech Stack & Versions

- **PHP**: 8.4.12
- **Framework**: Laravel 13.34.0 (Latest Stable)
- **Reactive UI**: Livewire 4.4.7 (Latest Stable)
- **CSS Engine**: Tailwind CSS v4.0.0 + `@tailwindcss/vite`
- **Bundler**: Vite 8.3.3
- **Database**: MySQL / MariaDB (Database: `portal_directory`)
- **PDF Engine**: `barryvdh/laravel-dompdf` (DomPDF 3.1.6)
- **Spreadsheet / CSV Engine**: `phpoffice/phpspreadsheet` (5.10.0)

---

## ⚙️ Prerequisites

- PHP 8.4 or higher with `pdo_mysql`, `mbstring`, `openssl`, `gd`, `zip`, `fileinfo` extensions enabled.
- Composer 2.8+
- Node.js 20+ and npm 10+
- MySQL / MariaDB Server running (e.g. Laragon, XAMPP, or standalone MySQL).

---

## 🚀 Installation & Setup

### 1. Clone & Enter Project Directory
```bash
cd d:\laragon\www\portal-directory
```

### 2. Environment Configuration
Verify or edit `.env`:
```env
APP_NAME="Portal Directory"
APP_ENV=local
APP_KEY=base64:jq/VhtxvdnaO/QpgOlzEd9LtOq5rR9LVLWXeNBULVC8=
APP_DEBUG=true
APP_TIMEZONE=Asia/Karachi
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_directory
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Database Migration & Baseline Seeding
Run migrations and populate baseline departments, users, roles, categories, portals, and activities:
```bash
php artisan migrate:fresh --seed
```

### 5. Build Frontend Assets
```bash
npm run build
```
Or for local hot-reloading during development:
```bash
npm run dev
```

### 6. Serve Application
```bash
php artisan serve
```
Access at: `http://127.0.0.1:8000` or through Laragon virtual host: `http://portal-directory.test`.

---

## 🔑 Default User Accounts (Seeded)

All seeded demo accounts use the standard password: **`Password123!`**

| Role | Name | Email | Department |
| :--- | :--- | :--- | :--- |
| **Administrator** | System Administrator | `admin@example.org` | *Global Access* |
| **Director** | Dr. Kamran Malik | `director.it@example.org` | IT Software Wing |
| **Director** | Syed Tahir Naqvi | `director.finance@example.org` | Finance & Accounts |
| **Director** | Ayesha Siddiqua | `director.hr@example.org` | Human Resources Wing |
| **Employee** | Muhammad Ali | `ali@example.org` | IT Software Wing |
| **Employee** | Ahmed Khan | `ahmed@example.org` | IT Software Wing |
| **Employee** | Usman Raza | `usman@example.org` | IT Software Wing |
| **Employee** | Zainab Bibi | `zainab@example.org` | Finance & Accounts |
| **Employee** | Bilal Hassan | `bilal@example.org` | Human Resources Wing |

*(The login screen also features 1-click credential fill buttons for fast testing).*

---

## 🧪 Automated Testing

Run the automated test suite covering Authentication, Authorization, Department CRUD & CSV Import, Portal Ownership & Visibility, and Report Exports:
```bash
php artisan test
```

Test Results: **24 Tests Passed, 63 Assertions Passed**.

---

## 🛡️ Role & Permission Matrix

| Feature | Admin | Director | Employee |
| :--- | :---: | :---: | :---: |
| **Global Dashboard** | ✅ | ❌ | ❌ |
| **User Management** | ✅ | ❌ | ❌ |
| **Department Management & CSV Import** | ✅ | ❌ | ❌ |
| **Directory Design Settings & Live Preview** | ✅ | ❌ | ❌ |
| **Activity Audit Trail & Diffs** | ✅ | ❌ | ❌ |
| **Director Department Dashboard** | ❌ | ✅ | ❌ |
| **Department Personnel Roster** | ❌ | ✅ (Own Dept Only) | ❌ |
| **Department Portals Inspector** | ❌ | ✅ (Own Dept Only) | ❌ |
| **Employee Dashboard & Portal Management** | ❌ | ❌ | ✅ |
| **Add / Edit Portals** | ✅ (All) | ✅ (Own) | ✅ (Own) |
| **View Directory** | ✅ (All) | ✅ (Own Dept / Targets) | ✅ (Own Dept / Targets) |
| **Generate PDF & Standalone HTML Reports** | ✅ (All Depts) | ✅ (Own Dept Only) | ❌ |
