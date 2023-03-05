<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class SelectDate extends Component
{
    public $date;

    public function mount()
    {
        $this->date = today();
    }

    public function updatedDate($val)
    {
        dd($val);
    }


    public function render()
    {
        return view('livewire.dashboard.select-date');
    }
}
