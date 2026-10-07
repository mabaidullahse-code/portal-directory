<?php

namespace App\Livewire\Employee;

use App\Enums\PortalStatus;
use App\Models\Category;
use App\Models\Portal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public string $search = '';

    public string $statusFilter = 'all';

    public string $categoryFilter = 'all';

    public string $sortOrder = 'latest';

    public string $viewLayout = 'grid'; // grid or list

    public function render()
    {
        $employee = Auth::user();

        $query = Portal::where('user_id', $employee->id)
            ->with(['category', 'targetDepartments', 'targetUsers'])
            ->search($this->search);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->sortOrder === 'title') {
            $query->orderBy('title');
        } elseif ($this->sortOrder === 'oldest') {
            $query->oldest('id');
        } else {
            $query->latest('id');
        }

        $myPortals = $query->get();

        $totalPortals = Portal::where('user_id', $employee->id)->count();
        $activePortals = Portal::where('user_id', $employee->id)->where('status', PortalStatus::ACTIVE->value)->count();
        $categories = Category::active()->ordered()->get();

        // Also check if any portals are targeted to this employee or employee's department!
        $targetedToMe = Portal::query()
            ->where('user_id', '!=', $employee->id)
            ->where(function ($q) use ($employee) {
                $q->whereHas('targetUsers', fn ($uq) => $uq->where('users.id', $employee->id));
                if ($employee->department_id) {
                    $q->orWhereHas('targetDepartments', fn ($dq) => $dq->where('departments.id', $employee->department_id));
                }
            })
            ->active()
            ->take(6)
            ->get();

        return view('livewire.employee.dashboard', [
            'employee' => $employee,
            'myPortals' => $myPortals,
            'totalPortals' => $totalPortals,
            'activePortals' => $activePortals,
            'categories' => $categories,
            'targetedToMe' => $targetedToMe,
        ])->layout('layouts.app', ['title' => 'Employee Portal Dashboard']);
    }
}
