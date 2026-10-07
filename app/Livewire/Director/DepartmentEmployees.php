<?php

namespace App\Livewire\Director;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentEmployees extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $director = Auth::user();
        $department = $director->department;

        $employees = User::where('department_id', $department->id)
            ->where('role', UserRole::EMPLOYEE->value)
            ->with(['portals' => fn ($q) => $q->orderBy('sort_order')->orderBy('title')])
            ->withCount('portals')
            ->search($this->search)
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.director.department-employees', [
            'department' => $department,
            'employees' => $employees,
        ])->layout('layouts.app', ['title' => "Department Staff Roster - {$department->name}"]);
    }
}
