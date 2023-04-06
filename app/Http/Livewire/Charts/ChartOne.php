<?php

namespace App\Http\Livewire\Charts;

use Livewire\Component;

class ChartOne extends Component
{
    public $label = [];
    public $data = [];

    public function render()
    {
        return view('livewire.charts.chart-one');
    }
}
