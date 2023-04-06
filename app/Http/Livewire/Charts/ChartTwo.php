<?php

namespace App\Http\Livewire\Charts;

use Livewire\Component;

class ChartTwo extends Component
{
    public $label = [];
    public $data = [];

    public function render()
    {
        return view('livewire.charts.chart-two');
    }
}
