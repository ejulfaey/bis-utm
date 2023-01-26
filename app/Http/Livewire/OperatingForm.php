<?php

namespace App\Http\Livewire;

use App\Models\Calculator;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Livewire\Component;

class OperatingForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Calculator $calculator;

    // Operating
    public $e_energy_of_consumption;
    public $e_duration_of_consumption;
    public $e_tariff;
    public $w_usage_of_water;
    public $w_no_of_occupants;
    public $w_tariff;

    public $total_energy_usage;
    public $daily_electrical_cost;
    public $yearly_electrical_cost;

    public $total_water_usage;
    public $daily_water_cost;
    public $yearly_water_cost;

    public function mount(): void
    {
        $this->calculator = Calculator::first();

        $this->form->fill([
            'e_energy_of_consumption' => $this->calculator->e_energy_of_consumption,
            'e_duration_of_consumption' => $this->calculator->e_duration_of_consumption,
            'e_tariff' => $this->calculator->e_tariff,
            'total_energy_usage' => $this->calculator->total_energy_usage,
            'daily_electrical_cost' => $this->calculator->daily_electrical_cost,
            'yearly_electrical_cost' => $this->calculator->yearly_electrical_cost,
            'w_usage_of_water' => $this->calculator->w_usage_of_water,
            'w_no_of_occupants' => $this->calculator->w_no_of_occupants,
            'w_tariff' => $this->calculator->w_tariff,
            'total_water_usage' => $this->calculator->total_water_usage,
            'daily_water_cost' => $this->calculator->daily_water_cost,
            'yearly_water_cost' => $this->calculator->yearly_water_cost,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Operating Cost (OPC)')
                ->schema([
                    Forms\Components\Section::make('Electrical Cost')
                        ->schema([
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('e_energy_of_consumption')
                                        ->label('Energy of consumption (KWatt)')
                                        ->numeric()
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state) => $this->updateField($state, 1)),
                                    Forms\Components\TextInput::make('e_duration_of_consumption')
                                        ->label('Duration of consumption (hour)')
                                        ->numeric()
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state) => $this->updateField($state, 1)),
                                    Forms\Components\TextInput::make('total_energy_usage')
                                        ->label('Total energy usage (Kwh/day)')
                                        ->reactive()
                                        ->disabled(),
                                ]),
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('e_tariff')
                                        ->label('Tariff/rate of usage (RM)')
                                        ->numeric()
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state) => $this->updateField($state, 1)),
                                    Forms\Components\TextInput::make('daily_electrical_cost')
                                        ->label('Total electrical cost (RM/day)')
                                        ->reactive()
                                        ->disabled(),
                                    Forms\Components\TextInput::make('yearly_electrical_cost')
                                        ->label('Total electrical cost (RM/year)')
                                        ->reactive()
                                        ->disabled(),
                                ]),
                        ]),
                    Forms\Components\Section::make('Water Cost')
                        ->schema([
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('w_usage_of_water')
                                        ->label('Usage of water demand (m3)')
                                        ->numeric()
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state) => $this->updateField($state, 2)),
                                    Forms\Components\TextInput::make('w_no_of_occupants')
                                        ->label('No. of occupants')
                                        ->numeric()
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state) => $this->updateField($state, 2)),
                                    Forms\Components\TextInput::make('total_water_usage')
                                        ->label('Total water usage (m3/day)')
                                        ->reactive()
                                        ->disabled(),
                                ]),
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('w_tariff')
                                        ->label('Tariff/rate of usage (RM)')
                                        ->numeric()
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state) => $this->updateField($state, 2)),
                                    Forms\Components\TextInput::make('daily_water_cost')
                                        ->label('Total water cost (RM/day)')
                                        ->reactive()
                                        ->disabled(),
                                    Forms\Components\TextInput::make('yearly_water_cost')
                                        ->label('Total water cost (RM/year)')
                                        ->reactive()
                                        ->disabled(),
                                ]),
                        ]),
                ])
        ];
    }

    public function updateField($state, $type): void
    {
        if ($type == 1 && $this->e_energy_of_consumption && $this->e_duration_of_consumption && $this->e_tariff) {
            $this->total_energy_usage = $this->e_energy_of_consumption * $this->e_duration_of_consumption;
            $this->daily_electrical_cost = $this->total_energy_usage * $this->e_tariff;
            $this->yearly_electrical_cost = $this->daily_electrical_cost * 365;
        }
        if ($type != 1 && $this->w_usage_of_water && $this->w_no_of_occupants && $this->w_tariff) {
            $this->total_water_usage = $this->w_usage_of_water * $this->w_no_of_occupants;
            $this->daily_water_cost = $this->total_water_usage * $this->w_tariff;
            $this->yearly_water_cost = $this->daily_water_cost * 365;
        }
    }

    public function saveOperating(): void
    {
        $params = Arr::only($this->form->getState(), [
            'e_energy_of_consumption',
            'e_duration_of_consumption',
            'e_tariff',
            'w_usage_of_water',
            'w_no_of_occupants',
            'w_tariff',
        ]);

        Calculator::whereId(1)
            ->update($params);

        Notification::make()
            ->title('Saved successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }

    public function render()
    {
        return view('livewire.operating-form');
    }
}
