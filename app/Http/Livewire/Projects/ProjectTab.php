<?php

namespace App\Http\Livewire\Projects;

use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Filament\Tables;

class ProjectTab extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public Project $project;
    public $tabs;
    public $selectedTab = 'all';
    public $charts = [];

    public function mount(): void
    {
        $this->tabs = Parameter::whereGroupId(Parameter::COMPONENT)
            ->pluck('name', 'id')
            ->toArray();
        $this->refreshChart();
    }

    public function refreshChart()
    {
        $this->charts = [
            'chart-1' => [
                'label' => Parameter::whereGroupId(Parameter::CLASSIFICATION)->pluck('name')->toArray(),
                'data' => [],
            ],
            'chart-2' => [
                'label' => Parameter::whereGroupId(Parameter::LOCATION)->pluck('name')->toArray(),
                'data' => [],
            ],
            'chart-3' => [
                'label' => Parameter::whereGroupId(Parameter::SUBCOMPONENT)
                    ->when(function () {
                        return $this->selectedTab !== 'all';
                    }, function ($query) {
                        return $query->whereParentId($this->selectedTab);
                    })
                    ->pluck('name')->toArray(),
                'data' => [],
            ],
        ];
        $inspect = Inspection::with('classification', 'location', 'subcomponent')
            ->whereProjectId($this->project->id)
            ->when(function () {
                return $this->selectedTab !== 'all';
            }, function ($query) {
                return $query->whereComponentId($this->selectedTab);
            })->get();

        foreach ($this->charts['chart-1']['label'] as $label)
            array_push($this->charts['chart-1']['data'], $inspect->where('classification.name', $label)->count());
        foreach ($this->charts['chart-2']['label'] as $label)
            array_push($this->charts['chart-2']['data'], $inspect->where('location.name', $label)->count());
        foreach ($this->charts['chart-3']['label'] as $label)
            array_push($this->charts['chart-3']['data'], $inspect->where('subcomponent.name', $label)->count());
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('ID'),
            Tables\Columns\TextColumn::make('location.name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('component.name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('subcomponent.name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('total_matrix')
                ->label('Total Matrix')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('classification.name')
                ->sortable(),
            Tables\Columns\TextColumn::make('date')
                ->date(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Inspection::with('project')
            ->whereProjectId($this->project->id)
            ->when(function () {
                return $this->selectedTab !== 'all';
            }, function ($query) {
                return $query->whereComponentId($this->selectedTab);
            })
            ->latest();
    }

    public function setSelectedTab($tab)
    {
        $this->selectedTab = $tab;
        $this->refreshChart();
        $this->emit('refreshChartOne', $this->charts['chart-1']);
        $this->emit('refreshChartTwo', $this->charts['chart-2']);
        $this->emit('refreshChartThree', $this->charts['chart-3']);
    }

    public function render()
    {
        return view('livewire.projects.project-tab');
    }
}
