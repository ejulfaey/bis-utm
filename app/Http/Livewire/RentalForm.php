<?php

namespace App\Http\Livewire;

use App\Models\RentalCost;
use Livewire\Component;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;

class RentalForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public RentalCost $rental;
    public $total_rental;

    public function mount(): void
    {
        $this->rental = RentalCost::first();
        $this->total_rental = $this->rental->total_rental;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Rental Value (RV)')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('rental.cost_room')
                                ->label('Rental cost per unit (RM/day)')
                                ->afterStateUpdated(fn ($state) => $this->updateField($state))
                                ->numeric()
                                ->reactive(),
                            Forms\Components\TextInput::make('rental.no_of_room')
                                ->label('No. of unit')
                                ->afterStateUpdated(fn ($state) => $this->updateField($state))
                                ->integer()
                                ->reactive(),
                            Forms\Components\TextInput::make('total_rental')
                                ->label('Total of rental (RM/years)')
                                ->disabled()
                                ->columnSpan(2),
                        ])

                ])

        ];
    }

    public function updateField($state)
    {
        if ($this->rental->cost_room && $this->rental->no_of_room)
            $this->total_rental = round($this->rental->cost_room * $this->rental->no_of_room * 365, 2);
    }

    public function submit()
    {
        $param = Arr::only($this->form->getState()['rental'], ['cost_room', 'no_of_room']);
        $this->rental->update($param);

        Notification::make()
            ->title('Saved successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }

    public function render()
    {
        return view('livewire.rental-form');
    }
}
