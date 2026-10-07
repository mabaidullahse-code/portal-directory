<?php

namespace App\Livewire\Director;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DepartmentPortals extends Component
{
    public string $search = '';

    public string $statusFilter = 'all';

    public function render()
    {
        $director = Auth::user();
        $department = $director->department;

        $employeesQuery = User::where('department_id', $department->id)
            ->with(['portals' => function ($q) {
                if ($this->statusFilter !== 'all') {
                    $q->where('status', $this->statusFilter);
                }
                if (! empty($this->search)) {
                    $q->search($this->search);
                }
                $q->orderBy('sort_order')->orderBy('title');
            }])
            ->orderBy('name');

        $employees = $employeesQuery->get()->filter(fn ($u) => $u->portals->isNotEmpty());

        return view('livewire.director.department-portals', [
            'department' => $department,
            'employees' => $employees,
        ])->layout('layouts.app', ['title' => "Department Portals - {$department->name}"]);
    }
}
