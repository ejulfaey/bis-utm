<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class BarChart extends Component
{
    public $chartId;
    public $type = 'vertical';
    public $label;
    public $dataset;

    public function render()
    {
        return view('livewire.dashboard.bar-chart');
    }
}
