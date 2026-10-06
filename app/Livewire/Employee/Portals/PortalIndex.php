<?php

namespace App\Livewire\Employee\Portals;

use App\Enums\PortalStatus;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Portal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PortalIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = 'all';
    public string $statusFilter = 'all';

    public ?Portal $selectedPortal = null;
    public bool $showDetailsModal = false;

    public function viewPortal(int $portalId): void
    {
        $this->selectedPortal = Portal::where('user_id', Auth::id())
            ->with(['targetDepartments', 'targetUsers', 'category'])
            ->findOrFail($portalId);
        $this->showDetailsModal = true;
    }

    public function toggleStatus(int $portalId): void
    {
        $portal = Portal::where('user_id', Auth::id())->findOrFail($portalId);
        $oldStatus = $portal->status;
        $newStatus = $oldStatus === PortalStatus::ACTIVE ? PortalStatus::INACTIVE : PortalStatus::ACTIVE;
        $portal->update(['status' => $newStatus]);

        ActivityLog::record(
            'portal.status_toggled',
            "Employee changed portal '{$portal->title}' status to {$newStatus->label()}",
            $portal,
            ['status' => $oldStatus->value],
            ['status' => $newStatus->value]
        );

        session()->flash('success', "Portal '{$portal->title}' marked as {$newStatus->label()}.");
    }

    public function deletePortal(int $portalId): void
    {
        $portal = Portal::where('user_id', Auth::id())->findOrFail($portalId);
        $title = $portal->title;

        ActivityLog::record(
            'portal.deleted',
            "Employee deleted portal '{$title}'",
            $portal,
            $portal->toArray(),
            null
        );

        $portal->targetDepartments()->detach();
        $portal->targetUsers()->detach();
        $portal->delete();

        session()->flash('success', "Portal '{$title}' deleted successfully.");
    }

    public function render()
    {
        $query = Portal::where('user_id', Auth::id())
            ->with(['category', 'targetDepartments', 'targetUsers'])
            ->search($this->search)
            ->latest('id');

        if ($this->categoryFilter !== 'all') {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $portals = $query->paginate(10);
        $categories = Category::active()->ordered()->get();

        return view('livewire.employee.portals.portal-index', [
            'portals' => $portals,
            'categories' => $categories,
        ])->layout('layouts.app', ['title' => 'My Portals Management']);
    }
}
