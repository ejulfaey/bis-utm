<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Project;
use Livewire\Component;

class SelectProject extends Component
{
    public $project;

    public function updatedProject($val)
    {
        $this->emit('updateProject', $val);
    }

    public function render()
    {
        return view('livewire.dashboard.select-project', [
            'projects' => Project::latest()
                ->get(),
        ]);
    }
}
