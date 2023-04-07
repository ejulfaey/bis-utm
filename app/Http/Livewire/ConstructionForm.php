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
    public ConstructionCost $cc;
    public $building_type_id;
    public $initial_cost;

    protected function getFormSchema(): array
    {
        return [
            Section::make('Construction Cost (CC)')
                ->schema([
                    Forms\Components\Select::make('building_type_id')
                        ->label('Type of building')
                        ->options(Parameter::whereGroupId(Parameter::BUILDING_TYPE)->pluck('name', 'id'))
                        ->reactive()
                        ->searchable()
                        ->afterStateUpdated(fn ($state) => $this->updateField($state))
                        ->required(),
                    Grid::make(3)
                        ->hidden(function (callable $get) {
                        })
                        ->schema([
                            Forms\Components\TextInput::make('cc.area_of_building')
                                ->label('Area of building (m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('cc.construction_cost')
                                ->label('Construction Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('cc.mechanical_cost')
                                ->label('Mechanical Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('cc.electrical_cost')
                                ->label('Electrical Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('cc.hydraulic_cost')
                                ->label('Hydraulic Service Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),
                            Forms\Components\TextInput::make('cc.fire_service_cost')
                                ->label('Fire Service Cost (RM/m2)')
                                ->reactive()
                                ->numeric(),
                            Forms\Components\TextInput::make('cc.lift_cost')
                                ->label('Lift/Escalator Cost (RM/m2)')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->updateTotalCost())
                                ->numeric(),

                            Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('cc.total_cost')
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
        $this->cc = ConstructionCost::firstWhere('building_type_id', $type);
        $this->initial_cost = number_format(floatval($this->cc->total_cost) * $this->cc->area_of_building, 2);
    }

    public function updateTotalCost()
    {

        $total = array_sum([
            $this->cc->construction_cost,
            $this->cc->mechanical_cost,
            $this->cc->electrical_cost,
            $this->cc->hydraulic_cost,
            $this->cc->fire_service_cost,
            $this->cc->lift_cost
        ]);
        $this->cc->total_cost = number_format($total, 2);
        if ($this->cc->area_of_building > 0) $this->initial_cost = number_format(floatval($total) * $this->cc->area_of_building, 2);
    }

    public function saveConstruction(): void
    {
        $data = $this->form->getState()['cc'];
        foreach ($data as $key => $d) {
            $data[$key] = floatval(str_replace(",", "", $d));
        }
        $this->cc->update($data);

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
