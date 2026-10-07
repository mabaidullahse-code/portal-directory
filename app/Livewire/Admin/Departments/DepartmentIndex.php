<?php

namespace App\Livewire\Admin\Departments;

use App\Models\ActivityLog;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'all';

    public bool $showModal = false;

    public ?int $editingDepartmentId = null;

    public string $name = '';

    public string $short_name = '';

    public string $code = '';

    public string $description = '';

    public string $status = 'active';

    protected function rules(): array
    {
        $deptId = $this->editingDepartmentId;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('departments', 'name')->ignore($deptId)],
            'short_name' => ['nullable', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:50', Rule::unique('departments', 'code')->ignore($deptId)],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'short_name', 'code', 'description', 'editingDepartmentId']);
        $this->status = 'active';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function editDepartment(int $id): void
    {
        $dept = Department::findOrFail($id);
        $this->editingDepartmentId = $dept->id;
        $this->name = $dept->name;
        $this->short_name = $dept->short_name ?? '';
        $this->code = $dept->code;
        $this->description = $dept->description ?? '';
        $this->status = $dept->status;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function saveDepartment(): void
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'short_name' => $this->short_name ?: $this->name,
            'code' => strtoupper(trim($this->code)),
            'description' => $this->description ?: null,
            'status' => $this->status,
        ];

        if ($this->editingDepartmentId) {
            $dept = Department::findOrFail($this->editingDepartmentId);
            $oldValues = $dept->toArray();
            $dept->update($data);

            ActivityLog::record(
                'department.updated',
                "Administrator updated department '{$dept->name}' ({$dept->code})",
                $dept,
                $oldValues,
                $dept->toArray()
            );

            session()->flash('success', "Department '{$dept->name}' updated successfully.");
        } else {
            $dept = Department::create($data);

            ActivityLog::record(
                'department.created',
                "Administrator created department '{$dept->name}' ({$dept->code})",
                $dept,
                null,
                $dept->toArray()
            );

            session()->flash('success', "Department '{$dept->name}' created successfully.");
        }

        $this->showModal = false;
    }

    public function toggleStatus(int $id): void
    {
        $dept = Department::findOrFail($id);
        $oldStatus = $dept->status;
        $newStatus = $oldStatus === 'active' ? 'inactive' : 'active';
        $dept->update(['status' => $newStatus]);

        ActivityLog::record(
            'department.status_toggled',
            "Administrator changed department '{$dept->name}' status to {$newStatus}",
            $dept,
            ['status' => $oldStatus],
            ['status' => $newStatus]
        );

        session()->flash('success', "Department '{$dept->name}' status set to {$newStatus}.");
    }

    public function deleteDepartment(int $id): void
    {
        $dept = Department::findOrFail($id);

        if ($dept->users()->exists()) {
            session()->flash('error', "Cannot delete department '{$dept->name}' because it has assigned users.");

            return;
        }

        if ($dept->portals()->exists()) {
            session()->flash('error', "Cannot delete department '{$dept->name}' because it owns registered portals.");

            return;
        }

        $deptName = $dept->name;
        ActivityLog::record(
            'department.deleted',
            "Administrator deleted department '{$deptName}'",
            $dept,
            $dept->toArray(),
            null
        );

        $dept->delete();

        session()->flash('success', "Department '{$deptName}' has been deleted.");
    }

    public function render()
    {
        $query = Department::query()
            ->withCount(['users', 'directors', 'employees', 'portals'])
            ->search($this->search)
            ->orderBy('name');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.departments.department-index', [
            'departments' => $query->paginate(10),
        ])->layout('layouts.app', ['title' => 'Department Management']);
    }
}
