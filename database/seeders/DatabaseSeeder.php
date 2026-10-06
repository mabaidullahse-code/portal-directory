<?php

namespace Database\Seeders;

use App\Enums\PortalDisplayDesign;
use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Department;
use App\Models\Portal;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Initial Settings
        Setting::set('portal_directory_design', PortalDisplayDesign::CARD_GRID->value);
        Setting::set('organization_name', config('app.name', 'Portal Directory Organization'));
        Setting::set('support_email', 'support@example.org');

        // 2. Departments
        $departmentsData = [
            [
                'name' => 'IT Software Wing',
                'short_name' => 'Software Wing',
                'code' => 'ITSW',
                'description' => 'Enterprise application development, portal management, and software innovation wing.',
                'status' => 'active',
            ],
            [
                'name' => 'IT Infrastructure Wing',
                'short_name' => 'Infrastructure',
                'code' => 'ITINF',
                'description' => 'Network operations, servers, cloud hosting, and cybersecurity wing.',
                'status' => 'active',
            ],
            [
                'name' => 'Admissions & Student Affairs',
                'short_name' => 'Admissions',
                'code' => 'ADM',
                'description' => 'Undergraduate, postgraduate, and professional student admissions & registrations.',
                'status' => 'active',
            ],
            [
                'name' => 'Examination & Testing Services',
                'short_name' => 'Examinations',
                'code' => 'EXAM',
                'description' => 'Conduct of university examinations, tabulation of results, and degrees issuance.',
                'status' => 'active',
            ],
            [
                'name' => 'Finance & Accounts',
                'short_name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Budgeting, payroll processing, accounts audit, and fiscal management.',
                'status' => 'active',
            ],
            [
                'name' => 'Human Resources Wing',
                'short_name' => 'HR',
                'code' => 'HRD',
                'description' => 'Staff recruitment, performance appraisals, personnel records, and leave management.',
                'status' => 'active',
            ],
            [
                'name' => 'General Administration',
                'short_name' => 'Administration',
                'code' => 'ADMIN',
                'description' => 'Logistics, estate office, transport, procurement, and institutional protocol.',
                'status' => 'active',
            ],
        ];

        $deptModels = [];
        foreach ($departmentsData as $dData) {
            $deptModels[$dData['code']] = Department::create($dData);
        }

        // 3. Categories
        $categoriesData = [
            ['name' => 'Human Resources & Payroll', 'slug' => 'hr-payroll', 'description' => 'Employee services, leave records, salary slips', 'icon' => 'user-group'],
            ['name' => 'Admissions & Enrollment', 'slug' => 'admissions', 'description' => 'Student applications, entrance tests, scrutiny', 'icon' => 'academic-cap'],
            ['name' => 'Examinations & Results', 'slug' => 'examinations', 'description' => 'Date sheets, roll number slips, result cards', 'icon' => 'clipboard-document-check'],
            ['name' => 'Finance & Budget', 'slug' => 'finance', 'description' => 'Financial ledgers, fee vouchers, vendor payments', 'icon' => 'currency-dollar'],
            ['name' => 'IT & Infrastructure', 'slug' => 'it-infrastructure', 'description' => 'Helpdesk tickets, server status, network monitoring', 'icon' => 'server-stack'],
            ['name' => 'Governance & Protocol', 'slug' => 'governance', 'description' => 'Executive dashboards, circulars, meeting minutes', 'icon' => 'building-library'],
        ];

        $categoryModels = [];
        foreach ($categoriesData as $cData) {
            $categoryModels[$cData['slug']] = Category::create($cData);
        }

        // 4. Default Admin User
        $adminPassword = env('ADMIN_DEFAULT_PASSWORD', 'Password123!');
        $adminUser = User::create([
            'name' => 'System Administrator',
            'employee_id' => 'EMP-0001',
            'email' => 'admin@example.org',
            'phone' => '+92-300-1112233',
            'designation' => 'Chief Technology Officer',
            'role' => UserRole::ADMIN,
            'department_id' => null, // Global admin
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make($adminPassword),
            'email_verified_at' => now(),
        ]);

        // 5. Directors
        $directorIT = User::create([
            'name' => 'Dr. Kamran Malik',
            'employee_id' => 'EMP-0101',
            'email' => 'director.it@example.org',
            'phone' => '+92-300-2223344',
            'designation' => 'Director IT Software Wing',
            'role' => UserRole::DIRECTOR,
            'department_id' => $deptModels['ITSW']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        $directorFinance = User::create([
            'name' => 'Syed Tahir Naqvi',
            'employee_id' => 'EMP-0102',
            'email' => 'director.finance@example.org',
            'phone' => '+92-300-3334455',
            'designation' => 'Director Finance & Accounts',
            'role' => UserRole::DIRECTOR,
            'department_id' => $deptModels['FIN']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        $directorHR = User::create([
            'name' => 'Ayesha Siddiqua',
            'employee_id' => 'EMP-0103',
            'email' => 'director.hr@example.org',
            'phone' => '+92-300-4445566',
            'designation' => 'Director Human Resources',
            'role' => UserRole::DIRECTOR,
            'department_id' => $deptModels['HRD']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        // 6. Employees for IT Software Wing
        $empAli = User::create([
            'name' => 'Muhammad Ali',
            'employee_id' => 'EMP-1001',
            'email' => 'ali@example.org',
            'phone' => '+92-321-5556677',
            'designation' => 'Lead Software Engineer',
            'role' => UserRole::EMPLOYEE,
            'department_id' => $deptModels['ITSW']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        $empAhmed = User::create([
            'name' => 'Ahmed Khan',
            'employee_id' => 'EMP-1002',
            'email' => 'ahmed@example.org',
            'phone' => '+92-322-6667788',
            'designation' => 'Senior Full Stack Developer',
            'role' => UserRole::EMPLOYEE,
            'department_id' => $deptModels['ITSW']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        $empUsman = User::create([
            'name' => 'Usman Raza',
            'employee_id' => 'EMP-1003',
            'email' => 'usman@example.org',
            'phone' => '+92-323-7778899',
            'designation' => 'Software Engineer (Web)',
            'role' => UserRole::EMPLOYEE,
            'department_id' => $deptModels['ITSW']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        // Employees for Finance
        $empZainab = User::create([
            'name' => 'Zainab Bibi',
            'employee_id' => 'EMP-2001',
            'email' => 'zainab@example.org',
            'phone' => '+92-333-8889900',
            'designation' => 'Payroll & Accounts Officer',
            'role' => UserRole::EMPLOYEE,
            'department_id' => $deptModels['FIN']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        // Employees for HR
        $empBilal = User::create([
            'name' => 'Bilal Hassan',
            'employee_id' => 'EMP-3001',
            'email' => 'bilal@example.org',
            'phone' => '+92-334-9990011',
            'designation' => 'Assistant Registrar (HR)',
            'role' => UserRole::EMPLOYEE,
            'department_id' => $deptModels['HRD']->id,
            'status' => UserStatus::ACTIVE,
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        // 7. Seed Sample Portals
        $portalsData = [
            // Muhammad Ali's Portals (ITSW)
            [
                'title' => 'Employee Leave Management System',
                'url' => 'https://leaves.example.org',
                'purpose' => 'Automated leave requests, approvals, balance ledger, and substitute duty notifications.',
                'description' => 'Online system for staff to submit casual, medical, and earned leave requests with multi-tier workflow routing.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(3),
                'closing_date' => null,
                'category_id' => $categoryModels['hr-payroll']->id,
                'user_id' => $empAli->id,
                'department_id' => $empAli->department_id,
                'contact_person' => 'Muhammad Ali',
                'contact_email' => 'ali@example.org',
                'contact_phone' => '+92-321-5556677',
                'tags' => ['leaves', 'workflow', 'hr', 'staff'],
                'version' => '2.4.0',
                'sort_order' => 1,
                'target_depts' => [$deptModels['HRD']->id, $deptModels['ADMIN']->id, $deptModels['FIN']->id],
            ],
            [
                'title' => 'Undergraduate Admissions Portal',
                'url' => 'https://admissions.example.org',
                'purpose' => 'Online admission processing, merit list generation, and seat allocation for applicants.',
                'description' => 'Centralized application submission portal for medical, allied health sciences, and degree programs.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(1),
                'closing_date' => now()->addMonths(2),
                'category_id' => $categoryModels['admissions']->id,
                'user_id' => $empAli->id,
                'department_id' => $empAli->department_id,
                'contact_person' => 'Muhammad Ali',
                'contact_email' => 'ali@example.org',
                'contact_phone' => '+92-321-5556677',
                'tags' => ['students', 'admissions', 'merit', 'online'],
                'version' => '3.1.0',
                'sort_order' => 2,
                'target_depts' => [$deptModels['ADM']->id],
            ],
            [
                'title' => 'Faculty Research & Publication Repository',
                'url' => 'https://research.example.org',
                'purpose' => 'Digital indexing, citation tracking, and archival of faculty research papers and grants.',
                'description' => 'Open institutional research database indexed with international scientific metadata standards.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(6),
                'closing_date' => null,
                'category_id' => $categoryModels['governance']->id,
                'user_id' => $empAli->id,
                'department_id' => $empAli->department_id,
                'contact_person' => 'Muhammad Ali',
                'contact_email' => 'ali@example.org',
                'tags' => ['research', 'faculty', 'publications'],
                'version' => '1.2.0',
                'sort_order' => 3,
                'target_depts' => [],
            ],

            // Ahmed Khan's Portals (ITSW)
            [
                'title' => 'Electronic Attendance & Biometric Portal',
                'url' => 'https://attendance.example.org',
                'purpose' => 'Real-time biometric punch sync, shift monitoring, and overtime calculation.',
                'description' => 'Integrated with physical facial and thumbprint scanners across university campuses.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(4),
                'closing_date' => null,
                'category_id' => $categoryModels['hr-payroll']->id,
                'user_id' => $empAhmed->id,
                'department_id' => $empAhmed->department_id,
                'contact_person' => 'Ahmed Khan',
                'contact_email' => 'ahmed@example.org',
                'tags' => ['biometric', 'attendance', 'shifts'],
                'version' => '4.0.1',
                'sort_order' => 1,
                'target_depts' => [$deptModels['HRD']->id, $deptModels['FIN']->id],
            ],
            [
                'title' => 'E-Procurement & Inventory Tracking System',
                'url' => 'https://procurement.example.org',
                'purpose' => 'Tender issuance, vendor comparative statements, purchase orders, and store requisition.',
                'description' => 'Ensures PPRA compliance and transparent purchase workflows for institutional equipment.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(2),
                'closing_date' => null,
                'category_id' => $categoryModels['finance']->id,
                'user_id' => $empAhmed->id,
                'department_id' => $empAhmed->department_id,
                'contact_person' => 'Ahmed Khan',
                'contact_email' => 'ahmed@example.org',
                'tags' => ['tenders', 'procurement', 'inventory', 'stores'],
                'version' => '1.5.0',
                'sort_order' => 2,
                'target_depts' => [$deptModels['FIN']->id, $deptModels['ADMIN']->id],
            ],

            // Usman Raza's Portals (ITSW)
            [
                'title' => 'Student Complaint & Grievance Redressal Portal',
                'url' => 'https://grievance.example.org',
                'purpose' => 'Citizen & student feedback ticketing, inquiry assignment, and Ombudsman reporting.',
                'description' => 'Dedicated portal for prompt resolution of student academic and administrative complaints.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(5),
                'closing_date' => null,
                'category_id' => $categoryModels['governance']->id,
                'user_id' => $empUsman->id,
                'department_id' => $empUsman->department_id,
                'contact_person' => 'Usman Raza',
                'contact_email' => 'usman@example.org',
                'tags' => ['helpdesk', 'complaints', 'students'],
                'version' => '2.0.0',
                'sort_order' => 1,
                'target_depts' => [$deptModels['ADM']->id, $deptModels['EXAM']->id],
            ],
            [
                'title' => 'Legacy Result Archive (Historical 1990-2015)',
                'url' => 'https://legacy-results.example.org',
                'purpose' => 'Read-only archival lookup for digitized historical examination ledgers.',
                'description' => 'Specialized access portal for verification of pre-computerized degree awards.',
                'status' => PortalStatus::INACTIVE,
                'opening_date' => now()->subYears(2),
                'closing_date' => now()->subMonths(1),
                'category_id' => $categoryModels['examinations']->id,
                'user_id' => $empUsman->id,
                'department_id' => $empUsman->department_id,
                'contact_person' => 'Usman Raza',
                'contact_email' => 'usman@example.org',
                'tags' => ['archive', 'records', 'legacy'],
                'version' => '1.0.0',
                'sort_order' => 2,
                'target_depts' => [$deptModels['EXAM']->id],
            ],

            // Director IT's Own Portal
            [
                'title' => 'IT Infrastructure & NOC Health Monitor',
                'url' => 'https://noc.example.org',
                'purpose' => 'Network operations center ping status, bandwidth utilization, and data center alerts.',
                'description' => 'Executive telemetry dashboard providing real-time uptime stats for all university servers.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(8),
                'closing_date' => null,
                'category_id' => $categoryModels['it-infrastructure']->id,
                'user_id' => $directorIT->id,
                'department_id' => $directorIT->department_id,
                'contact_person' => 'Dr. Kamran Malik',
                'contact_email' => 'director.it@example.org',
                'tags' => ['monitoring', 'servers', 'noc', 'telemetry'],
                'version' => '3.0.0',
                'sort_order' => 0,
                'target_depts' => [$deptModels['ITSW']->id, $deptModels['ITINF']->id],
            ],

            // Zainab Bibi's Portal (Finance)
            [
                'title' => 'Employee Payroll & Salary Disbursement System',
                'url' => 'https://payroll.example.org',
                'purpose' => 'Monthly pay slip generation, tax deductions, pension disbursement, and bank advice export.',
                'description' => 'Comprehensive payroll processing suite with computerized bank scrolls and automated income tax slabs.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(10),
                'closing_date' => null,
                'category_id' => $categoryModels['finance']->id,
                'user_id' => $empZainab->id,
                'department_id' => $empZainab->department_id,
                'contact_person' => 'Zainab Bibi',
                'contact_email' => 'zainab@example.org',
                'tags' => ['payroll', 'salary', 'tax', 'finance'],
                'version' => '4.2.0',
                'sort_order' => 1,
                'target_depts' => [$deptModels['FIN']->id, $deptModels['HRD']->id],
            ],

            // Bilal Hassan's Portal (HR)
            [
                'title' => 'Performance Evaluation & ACR Management System',
                'url' => 'https://acr.example.org',
                'purpose' => 'Annual Confidential Reports submission, countersigning, and promotion eligibility tracking.',
                'description' => 'Secure paperless appraisal engine for administrative and academic cadres.',
                'status' => PortalStatus::ACTIVE,
                'opening_date' => now()->subMonths(7),
                'closing_date' => null,
                'category_id' => $categoryModels['hr-payroll']->id,
                'user_id' => $empBilal->id,
                'department_id' => $empBilal->department_id,
                'contact_person' => 'Bilal Hassan',
                'contact_email' => 'bilal@example.org',
                'tags' => ['acr', 'appraisal', 'performance', 'hr'],
                'version' => '2.1.0',
                'sort_order' => 1,
                'target_depts' => [$deptModels['HRD']->id],
            ],
        ];

        foreach ($portalsData as $pData) {
            $targetDeptIds = $pData['target_depts'] ?? [];
            unset($pData['target_depts']);

            $portal = Portal::create($pData);
            if (!empty($targetDeptIds)) {
                $portal->targetDepartments()->sync($targetDeptIds);
            }

            ActivityLog::record(
                'portal.created',
                "Created portal '{$portal->title}'",
                $portal,
                null,
                $portal->toArray(),
                $portal->user
            );
        }

        ActivityLog::record(
            'system.seeded',
            'Database successfully populated with baseline departments, users, and enterprise portals.',
            null,
            null,
            null,
            $adminUser
        );
    }
}
