<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Project;
use Livewire\Component;

class SelectProject extends Component
{
    public $project;

    public function mount()
    {
        $this->project = null;
    }

    public function updatedProject()
    {
        dd('project');
    }

    public function render()
    {
        return view('livewire.dashboard.select-project', [
            'projects' => Project::latest()
                ->get(),
        ]);
    }
}
