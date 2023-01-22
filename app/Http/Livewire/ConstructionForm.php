<?php

namespace App\Http\Livewire;

use App\Models\ConstructionCost;
use App\Models\Parameter;
use Livewire\Component;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;

class ConstructionForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    // Construction
    public $area_of_building;
    public $building_type_id;
    public $construction_cost;
    public $mechanical_cost;
    public $electrical_cost;
    public $hydraulic_cost;
    public $fire_service_cost;
    public $lift_cost;
    public $total_cost;
    public $initial_cost;

    protected function getFormSchema(): array
    {
        return [
            Section::make('Construction Cost (CC)')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Forms\Components\Select::make('building_type_id')
                                ->label('Type of building')
                                ->options(Parameter::whereGroupId(Parameter::BUILDING_TYPE)->pluck('name', 'id'))
                                ->reactive()
                                ->afterStateUpdated(fn ($state) => $this->updateField($state))
                                ->required(),
                            Forms\Components\TextInput::make('area_of_building')
                                ->label('Area of building (m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('construction_cost')
                                ->label('Construction Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('mechanical_cost')
                                ->label('Mechanical Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('electrical_cost')
                                ->label('Electrical Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('hydraulic_cost')
                                ->label('Hydraulic Service Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('fire_service_cost')
                                ->label('Fire Service Cost (RM/m2)')
                                ->reactive()
                                ->numeric(),
                            Forms\Components\TextInput::make('lift_cost')
                                ->label('Lift/Escalator Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),

                            Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('total_cost')
                                        ->label('Total Cost Construction and Service (RM/m2)')
                                        ->reactive()
                                        ->disabled(),
                                    Forms\Components\TextInput::make('initial_cost')
                                        ->label('Initial Cost of Construction (RM)')
                                        ->reactive()
                                        ->disabled(),
                                ])
                        ]),
                ]),

        ];
    }

    public function updateField($type)
    {
        $construction = ConstructionCost::firstWhere('building_type_id', $type);
        $this->area_of_building = $construction->area_of_building;
        $this->construction_cost = $construction->construction_cost;
        $this->mechanical_cost = $construction->mechanical_cost;
        $this->electrical_cost = $construction->electrical_cost;
        $this->hydraulic_cost = $construction->hydraulic_cost;
        $this->fire_service_cost = $construction->fire_service_cost;
        $this->lift_cost = $construction->lift_cost;
        $this->total_cost = $construction->total_cost;
        $this->initial_cost = number_format($this->total_cost * $this->area_of_building, 2);
    }

    public function updateTotalCost()
    {
        $this->total_cost = number_format(array_sum([
            $this->construction_cost,
            $this->mechanical_cost,
            $this->electrical_cost,
            $this->hydraulic_cost,
            $this->fire_service_cost,
            $this->lift_cost
        ]), 2);
        if ($this->area_of_building > 0)
            $this->initial_cost = number_format($this->total_cost * $this->area_of_building, 2);
    }

    public function saveConstruction(): void
    {
        $construction = ConstructionCost::firstWhere('building_type_id', $this->building_type_id);
        $construction->area_of_building = $this->area_of_building;
        $construction->construction_cost = $this->construction_cost;
        $construction->mechanical_cost = $this->mechanical_cost;
        $construction->electrical_cost = $this->electrical_cost;
        $construction->hydraulic_cost = $this->hydraulic_cost;
        $construction->fire_service_cost = $this->fire_service_cost;
        $construction->lift_cost = $this->lift_cost;
        $construction->total_cost = $this->total_cost;
        $construction->save();

        Notification::make()
            ->title('Saved successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }

    public function render()
    {
        return view('livewire.construction-form');
    }
}
