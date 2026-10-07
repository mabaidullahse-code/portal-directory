<?php

namespace App\Livewire\Director;

use App\Enums\PortalStatus;
use App\Models\ActivityLog;
use App\Models\Portal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyPortals extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'all';

    public function toggleStatus(int $portalId): void
    {
        $portal = Portal::where('user_id', Auth::id())->findOrFail($portalId);
        $oldStatus = $portal->status;
        $newStatus = $oldStatus === PortalStatus::ACTIVE ? PortalStatus::INACTIVE : PortalStatus::ACTIVE;
        $portal->update(['status' => $newStatus]);

        ActivityLog::record(
            'portal.status_toggled',
            "Director changed status of '{$portal->title}' to {$newStatus->label()}",
            $portal,
            ['status' => $oldStatus->value],
            ['status' => $newStatus->value]
        );

        session()->flash('success', "Portal '{$portal->title}' status set to {$newStatus->label()}.");
    }

    public function deletePortal(int $portalId): void
    {
        $portal = Portal::where('user_id', Auth::id())->findOrFail($portalId);
        $title = $portal->title;

        ActivityLog::record(
            'portal.deleted',
            "Director deleted portal '{$title}'",
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
            ->search($this->search)
            ->latest('id');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.director.my-portals', [
            'portals' => $query->paginate(10),
        ])->layout('layouts.app', ['title' => 'Director - My Portals']);
    }
}
