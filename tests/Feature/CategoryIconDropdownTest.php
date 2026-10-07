<?php

namespace Tests\Feature;

use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use App\Support\IconHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryIconDropdownTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Department $department;

    protected function setUp(): void
    {
        parent::setUp();

        $this->department = Department::create([
            'name' => 'IT Department',
            'code' => 'IT',
            'status' => 'active',
        ]);
        $this->admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@test.org',
            'password' => bcrypt('Password123!'),
            'plain_password' => 'Password123!',
            'role' => 'admin',
            'department_id' => $this->department->id,
            'status' => 'active',
        ]);
    }

    public function test_icon_helper_returns_curated_groups_and_all_icons(): void
    {
        $options = IconHelper::getSelectOptions(allowHtml: true);

        $this->assertArrayHasKey('Academic & Education', $options);
        $this->assertArrayHasKey('Human Resources & Personnel', $options);
        $this->assertArrayHasKey('Governance & Compliance', $options);
        $this->assertArrayHasKey('Finance & Procurement', $options);
        $this->assertArrayHasKey('IT & Digital Infrastructure', $options);
        $this->assertArrayHasKey('Communication & Support', $options);
        $this->assertArrayHasKey('Campus Facilities & Operations', $options);
        $this->assertArrayHasKey('All Other Icons', $options);

        $this->assertArrayHasKey('user-group', $options['Human Resources & Personnel']);
        $this->assertArrayHasKey('academic-cap', $options['Academic & Education']);
        $this->assertArrayHasKey('server-stack', $options['IT & Digital Infrastructure']);

        $this->assertEquals('heroicon-o-user-group', IconHelper::toHeroicon('user-group'));
        $this->assertEquals('heroicon-o-academic-cap', IconHelper::toHeroicon('academic-cap'));
        $this->assertNull(IconHelper::toHeroicon(null));
    }

    public function test_admin_can_choose_icon_from_dropdown_and_save_category(): void
    {
        $category = Category::create([
            'name' => 'Human Resources & Payroll',
            'slug' => 'hr-payroll',
            'description' => 'Employee services, leave records, salary slips',
            'icon' => 'user-group',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(EditCategory::class, ['record' => $category->getKey()])
            ->assertSchemaStateSet([
                'icon' => 'user-group',
            ])
            ->set('data.icon', 'academic-cap')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'icon' => 'academic-cap',
        ]);
    }
}
