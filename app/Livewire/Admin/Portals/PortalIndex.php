<?php

namespace App\Livewire\Admin\Portals;

use App\Enums\PortalStatus;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Department;
use App\Models\Portal;
use Livewire\Component;
use Livewire\WithPagination;

class PortalIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $departmentFilter = 'all';
    public string $categoryFilter = 'all';
    public string $statusFilter = 'all';

    public ?Portal $selectedPortal = null;
    public bool $showDetailsModal = false;

    public function viewDetails(int $portalId): void
    {
        $this->selectedPortal = Portal::with(['user', 'department', 'category', 'targetDepartments', 'targetUsers'])->findOrFail($portalId);
        $this->showDetailsModal = true;
    }

    public function toggleStatus(int $portalId): void
    {
        $portal = Portal::findOrFail($portalId);
        $oldStatus = $portal->status;
        $newStatus = $oldStatus === PortalStatus::ACTIVE ? PortalStatus::INACTIVE : PortalStatus::ACTIVE;
        $portal->update(['status' => $newStatus]);

        ActivityLog::record(
            'portal.status_toggled',
            "Administrator toggled status of '{$portal->title}' to {$newStatus->label()}",
            $portal,
            ['status' => $oldStatus->value],
            ['status' => $newStatus->value]
        );

        session()->flash('success', "Portal '{$portal->title}' marked as {$newStatus->label()}.");
    }

    public function deletePortal(int $portalId): void
    {
        $portal = Portal::findOrFail($portalId);
        $title = $portal->title;

        ActivityLog::record(
            'portal.deleted',
            "Administrator deleted portal '{$title}'",
            $portal,
            $portal->toArray(),
            null
        );

        $portal->targetDepartments()->detach();
        $portal->targetUsers()->detach();
        $portal->delete();

        session()->flash('success', "Portal '{$title}' has been deleted.");
    }

    public function render()
    {
        $query = Portal::query()
            ->with(['user', 'department', 'category'])
            ->search($this->search)
            ->latest('id');

        if ($this->departmentFilter !== 'all') {
            $query->where('department_id', $this->departmentFilter);
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $portals = $query->paginate(12);
        $departments = Department::active()->orderBy('name')->get();
        $categories = Category::active()->ordered()->get();

        return view('livewire.admin.portals.portal-index', [
            'portals' => $portals,
            'departments' => $departments,
            'categories' => $categories,
        ])->layout('layouts.app', ['title' => 'Portals Management']);
    }
}
