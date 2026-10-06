<?php

namespace App\Livewire\Portal;

use App\Enums\PortalStatus;
use App\Enums\UserRole;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Department;
use App\Models\Portal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PortalForm extends Component
{
    public ?Portal $portal = null;
    public bool $isEditing = false;

    // Fields
    public string $title = '';
    public string $url = '';
    public string $purpose = '';
    public string $description = '';
    public string $status = 'active';
    public ?string $opening_date = null;
    public ?string $closing_date = null;
    public ?int $category_id = null;
    public ?int $user_id = null; // Admin can assign, otherwise current user
    public ?int $department_id = null; // Automatically assigned from owner
    public string $contact_person = '';
    public string $contact_email = '';
    public string $contact_phone = '';
    public string $tags_string = '';
    public string $version = '';
    public string $remarks = '';
    public int $sort_order = 0;

    // Multi-select targets
    public array $target_department_ids = [];
    public array $target_user_ids = [];

    // Target user picker filter helpers
    public string $targetUserSearch = '';
    public string $targetUserDeptFilter = 'all';

    public function mount(?Portal $portal = null): void
    {
        $currentUser = Auth::user();

        if ($portal && $portal->exists) {
            // Authorize
            $this->authorize('update', $portal);

            $this->portal = $portal;
            $this->isEditing = true;
            $this->title = $portal->title;
            $this->url = $portal->url;
            $this->purpose = $portal->purpose ?? '';
            $this->description = $portal->description ?? '';
            $this->status = $portal->status->value;
            $this->opening_date = $portal->opening_date?->format('Y-m-d');
            $this->closing_date = $portal->closing_date?->format('Y-m-d');
            $this->category_id = $portal->category_id;
            $this->user_id = $portal->user_id;
            $this->department_id = $portal->department_id;
            $this->contact_person = $portal->contact_person ?? '';
            $this->contact_email = $portal->contact_email ?? '';
            $this->contact_phone = $portal->contact_phone ?? '';
            $this->tags_string = !empty($portal->tags) ? implode(', ', $portal->tags) : '';
            $this->version = $portal->version ?? '';
            $this->remarks = $portal->remarks ?? '';
            $this->sort_order = $portal->sort_order ?? 0;

            $this->target_department_ids = $portal->targetDepartments->pluck('id')->toArray();
            $this->target_user_ids = $portal->targetUsers->pluck('id')->toArray();
        } else {
            $this->authorize('create', Portal::class);

            $this->isEditing = false;
            $this->user_id = $currentUser->id;
            $this->department_id = $currentUser->department_id;
            $this->status = 'active';
            $this->contact_person = $currentUser->name;
            $this->contact_email = $currentUser->email;
            $this->contact_phone = $currentUser->phone ?? '';
        }
    }

    public function updatedUserId($newUserId): void
    {
        if (Auth::user()->isAdmin() && $newUserId) {
            $owner = User::find($newUserId);
            if ($owner && $owner->department_id) {
                $this->department_id = $owner->department_id;
            }
        }
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:2048', function ($attr, $value, $fail) {
                $trimmed = trim($value);
                if (preg_match('/^javascript:/i', $trimmed) || preg_match('/^data:/i', $trimmed)) {
                    $fail('The URL contains an insecure or disallowed protocol.');
                }
                // Verify valid URL format
                $normalized = preg_match('~^https?://~i', $trimmed) ? $trimmed : 'https://' . $trimmed;
                if (!filter_var($normalized, FILTER_VALIDATE_URL)) {
                    $fail('The URL format is invalid.');
                }
            }],
            'purpose' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'opening_date' => ['nullable', 'date'],
            'closing_date' => ['nullable', 'date', 'after_or_equal:opening_date'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'contact_person' => ['nullable', 'string', 'max:150'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'version' => ['nullable', 'string', 'max:50'],
            'remarks' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'target_department_ids' => ['nullable', 'array'],
            'target_department_ids.*' => ['exists:departments,id'],
            'target_user_ids' => ['nullable', 'array'],
            'target_user_ids.*' => ['exists:users,id'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $currentUser = Auth::user();

        // Normalize URL
        $cleanUrl = trim($this->url);
        if (!preg_match('~^https?://~i', $cleanUrl)) {
            $cleanUrl = 'https://' . $cleanUrl;
        }

        // Parse tags
        $tags = [];
        if (!empty($this->tags_string)) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $this->tags_string))));
        }

        // Determine owner & department
        $ownerId = $this->user_id;
        if (!$currentUser->isAdmin()) {
            $ownerId = $currentUser->id;
            $deptId = $currentUser->department_id;
        } else {
            $owner = User::find($ownerId);
            $deptId = $owner?->department_id ?: $this->department_id ?: Department::first()?->id;
        }

        $data = [
            'title' => $this->title,
            'url' => $cleanUrl,
            'purpose' => $this->purpose ?: null,
            'description' => $this->description ?: null,
            'status' => PortalStatus::from($this->status),
            'opening_date' => $this->opening_date ?: null,
            'closing_date' => $this->closing_date ?: null,
            'category_id' => $this->category_id ?: null,
            'user_id' => $ownerId,
            'department_id' => $deptId,
            'contact_person' => $this->contact_person ?: null,
            'contact_email' => $this->contact_email ?: null,
            'contact_phone' => $this->contact_phone ?: null,
            'tags' => $tags,
            'version' => $this->version ?: null,
            'remarks' => $this->remarks ?: null,
            'sort_order' => $this->sort_order ?: 0,
        ];

        if ($this->isEditing && $this->portal) {
            $oldValues = $this->portal->toArray();
            $this->portal->update($data);
            $this->portal->targetDepartments()->sync($this->target_department_ids);
            $this->portal->targetUsers()->sync($this->target_user_ids);

            ActivityLog::record(
                'portal.updated',
                "Updated portal '{$this->portal->title}'",
                $this->portal,
                $oldValues,
                $this->portal->toArray()
            );

            session()->flash('success', "Portal '{$this->portal->title}' updated successfully.");
        } else {
            $portal = Portal::create($data);
            $portal->targetDepartments()->sync($this->target_department_ids);
            $portal->targetUsers()->sync($this->target_user_ids);

            ActivityLog::record(
                'portal.created',
                "Created new portal '{$portal->title}'",
                $portal,
                null,
                $portal->toArray()
            );

            session()->flash('success', "Portal '{$portal->title}' registered successfully.");
        }

        // Role-based redirection
        if ($currentUser->isAdmin()) {
            $this->redirect(route('admin.portals.index'));
        } elseif ($currentUser->isDirector()) {
            $this->redirect(route('director.my-portals'));
        } else {
            $this->redirect(route('employee.portals.index'));
        }
    }

    public function render()
    {
        $categories = Category::active()->ordered()->get();
        $departments = Department::active()->orderBy('name')->get();

        // Target users available for multi-select
        $usersQuery = User::active()->with('department')->orderBy('name');
        if ($this->targetUserDeptFilter !== 'all') {
            $usersQuery->where('department_id', $this->targetUserDeptFilter);
        }
        if (!empty($this->targetUserSearch)) {
            $usersQuery->search($this->targetUserSearch);
        }
        $availableUsers = $usersQuery->take(30)->get();

        // Owner users list if Admin
        $ownerUsers = Auth::user()->isAdmin() ? User::active()->with('department')->orderBy('name')->get() : collect();

        return view('livewire.portal.portal-form', [
            'categories' => $categories,
            'departments' => $departments,
            'availableUsers' => $availableUsers,
            'ownerUsers' => $ownerUsers,
        ])->layout('layouts.app', ['title' => $this->isEditing ? 'Edit Portal' : 'Register New Portal']);
    }
}
