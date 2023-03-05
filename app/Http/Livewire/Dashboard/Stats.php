<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Stats extends Component
{
    public $stats;

    public function mount()
    {
        // 
    }


    public function render()
    {
        return view('livewire.dashboard.stats');
    }
}
