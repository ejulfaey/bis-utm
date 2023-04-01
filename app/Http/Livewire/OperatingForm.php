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

    public Calculator $cost;

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
        $this->cost = Calculator::first();
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
                                    Forms\Components\TextInput::make('cost.e_energy_of_consumption')
                                        ->label('Energy of consumption (KWatt)')
                                        ->reactive()
                                        ->numeric(),
                                    Forms\Components\TextInput::make('cost.e_duration_of_consumption')
                                        ->label('Duration of consumption (hour)')
                                        ->reactive()
                                        ->numeric(),
                                    Forms\Components\TextInput::make('cost.total_energy_usage')
                                        ->label('Total energy usage (Kwh/day)')
                                        ->disabled(),
                                ]),
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('cost.e_tariff')
                                        ->label('Tariff/rate of usage (RM)')
                                        ->numeric()
                                        ->reactive(),
                                    Forms\Components\TextInput::make('cost.daily_electrical_cost')
                                        ->label('Total electrical cost (RM/day)')
                                        ->disabled(),
                                    Forms\Components\TextInput::make('cost.yearly_electrical_cost')
                                        ->label('Total electrical cost (RM/year)')
                                        ->disabled(),
                                ]),
                        ]),
                    Forms\Components\Section::make('Water Cost')
                        ->schema([
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('cost.w_usage_of_water')
                                        ->label('Usage of water demand (m3)')
                                        ->numeric()
                                        ->reactive(),
                                    Forms\Components\TextInput::make('cost.w_no_of_occupants')
                                        ->label('No. of occupants')
                                        ->numeric()
                                        ->reactive(),
                                    Forms\Components\TextInput::make('cost.total_water_usage')
                                        ->label('Total water usage (m3/day)')
                                        ->disabled(),
                                ]),
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('cost.w_tariff')
                                        ->label('Tariff/rate of usage (RM)')
                                        ->numeric()
                                        ->reactive(),
                                    Forms\Components\TextInput::make('cost.daily_water_cost')
                                        ->label('Total water cost (RM/day)')
                                        ->disabled(),
                                    Forms\Components\TextInput::make('cost.yearly_water_cost')
                                        ->label('Total water cost (RM/year)')
                                        ->disabled(),
                                ]),
                        ]),
                ])
        ];
    }

    public function saveOperating(): void
    {
        $params = Arr::only($this->form->getState()['cost'], [
            'e_energy_of_consumption',
            'e_duration_of_consumption',
            'e_tariff',
            'w_usage_of_water',
            'w_no_of_occupants',
            'w_tariff',
        ]);

        foreach ($params as $key => $d) {
            $params[$key] = floatval(str_replace(",", "", $d));
        }

        $cost = Calculator::find(1);
        $cost->setAppends([]);
        $cost->e_energy_of_consumption = $this->cost->e_energy_of_consumption;
        $cost->e_duration_of_consumption = $this->cost->e_duration_of_consumption;
        $cost->e_tariff = $this->cost->e_tariff;
        $cost->w_usage_of_water = $this->cost->w_usage_of_water;
        $cost->w_no_of_occupants = $this->cost->w_no_of_occupants;
        $cost->w_tariff = $this->cost->w_tariff;
        $cost->save();

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
