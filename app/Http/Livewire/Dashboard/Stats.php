<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Inspection;
use App\Models\InspectionPhoto;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Stats extends Component
{
    public $projects;
    public $inspections;
    public $photos;
    public $users;

    public function mount()
    {
        $this->projects = Project::count();
        $this->inspections = Inspection::count();
        $this->photos = InspectionPhoto::count();
        $this->users = User::whereRoleId(Role::NORMAL)->count();
    }

    public function render()
    {
        return view('livewire.dashboard.stats');
    }
}
