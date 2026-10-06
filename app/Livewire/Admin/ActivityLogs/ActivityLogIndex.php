<?php

namespace App\Livewire\Admin\ActivityLogs;

use App\Models\ActivityLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $actionFilter = 'all';
    public string $userFilter = 'all';

    public ?ActivityLog $selectedLog = null;
    public bool $showDetailsModal = false;

    public function viewDetails(int $id): void
    {
        $this->selectedLog = ActivityLog::with('user')->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function render()
    {
        $query = ActivityLog::query()
            ->with('user')
            ->latest('created_at');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                  ->orWhere('ip_address', 'like', "%{$this->search}%")
                  ->orWhere('action', 'like', "%{$this->search}%");
            });
        }

        if ($this->actionFilter !== 'all') {
            $query->where('action', $this->actionFilter);
        }

        if ($this->userFilter !== 'all') {
            $query->where('user_id', $this->userFilter);
        }

        $logs = $query->paginate(15);
        $users = User::orderBy('name')->get();
        $distinctActions = ActivityLog::distinct()->pluck('action')->filter()->values();

        return view('livewire.admin.activity-logs.activity-log-index', [
            'logs' => $logs,
            'users' => $users,
            'distinctActions' => $distinctActions,
        ])->layout('layouts.app', ['title' => 'Activity Audit Logs']);
    }
}
