<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LivewireChart extends Component
{
    public $chartId;
    public $label;
    public $data;

    public function mount($chartId = null, $label = [], $data = [])
    {
        $this->chartId = $chartId;
        $this->label = $label;
        $this->data = $data;
        $this->emit('init', 'test');
    }

    public function render()
    {
        return view('livewire.livewire-chart');
    }
}
