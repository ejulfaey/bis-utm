<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class SelectDate extends Component
{
    public $date;

    public function mount()
    {
        $this->date = today()->format('Y-m-d');
    }

    public function updatedDate($val)
    {
        $this->emit('updatedDate', $val);
    }


    public function render()
    {
        return view('livewire.dashboard.select-date');
    }
}
