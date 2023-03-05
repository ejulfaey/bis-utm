<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DonutChart extends Component
{
    public $chartId;
    public $title = 'Chart 1';
    public $label;
    public $dataset;

    public function render()
    {
        return view('livewire.dashboard.donut-chart');
    }
}
