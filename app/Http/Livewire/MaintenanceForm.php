<?php

namespace App\Http\Livewire;

use App\Models\MaintenanceCost;
use App\Models\Parameter;
use Livewire\Component;
use Filament\Tables;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;

class MaintenanceForm extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public $type;
    public $no;
    public $building_section;
    public $subcomponent_id;
    public $area;
    public $cost;
    public $no_of_unit;
    public $total_cost;
    public $isEdit = null;

    protected function getTableQuery(): Builder|Relation
    {
        return MaintenanceCost::query()->latest();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Maintenance Cost (MC)')
                ->schema([
                    Forms\Components\TextInput::make('no')
                        ->label('No.')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('building_section')
                        ->required(),
                    Forms\Components\Select::make('subcomponent_id')
                        ->label('Building Component')
                        ->searchable()
                        ->options(Parameter::whereGroupId(Parameter::SUBCOMPONENT)->pluck('name', 'id'))
                        ->required(),
                    Forms\Components\TextInput::make('area')
                        ->label('Area (m2)')
                        ->numeric()
                        ->reactive()
                        ->afterStateUpdated(fn () => $this->updateField())
                        ->required(),
                    Forms\Components\TextInput::make('cost')
                        ->label('Cost (RM)')
                        ->numeric()
                        ->reactive()
                        ->afterStateUpdated(fn () => $this->updateField())
                        ->required(),
                    Forms\Components\TextInput::make('no_of_unit')
                        ->label('No. of unit')
                        ->integer()
                        ->reactive()
                        ->afterStateUpdated(fn () => $this->updateField())
                        ->required(),
                    Forms\Components\TextInput::make('total_cost')
                        ->label('Total Cost (RM)')
                        ->disabled(),
                ])->columns(4),
        ];
    }

    public function updateField()
    {
        if ($this->area && $this->cost && $this->no_of_unit)
            $this->total_cost = round($this->area * $this->cost * $this->no_of_unit, 2);
    }


    public function submit()
    {
        if ($this->isEdit)
            MaintenanceCost::whereId($this->isEdit)
                ->update($this->form->getState());
        else
            MaintenanceCost::create($this->form->getState());

        Notification::make()
            ->title( $this->isEdit ? 'Updated successfully' : 'Created successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('no')
                ->label('No.')
                ->searchable(),
            Tables\Columns\TextColumn::make('building_section')
                ->label('Building Section')
                ->searchable(),
            Tables\Columns\TextColumn::make('component.name')
                ->label('Building Component'),
            Tables\Columns\TextColumn::make('area')
                ->label('Area (m2)'),
            Tables\Columns\TextColumn::make('cost')
                ->label('Cost (RM)'),
            Tables\Columns\TextColumn::make('no_of_unit')
                ->label('No. of unit'),
            Tables\Columns\TextColumn::make('total_cost')
                ->label('Total Cost (RM)'),

        ];
    }

    public function fillForm($record): void
    {
        $this->isEdit = $record->id;
        $this->form->fill([
            'no' => $record->no,
            'building_section' => $record->building_section,
            'subcomponent_id' => $record->subcomponent_id,
            'area' => $record->area,
            'cost' => $record->cost,
            'no_of_unit' => $record->no_of_unit,
            'total_cost' => $record->total_cost,
        ]);
    }

    public function cancelEdit(): void
    {
        $this->isEdit = null;
        $this->form->fill([
            'no' => '',
            'building_section' => '',
            'subcomponent_id' => '',
            'area' => '',
            'cost' => '',
            'no_of_unit' => '',
            'total_cost' => '',
        ]);
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->action(fn (Model $record) => $this->fillForm($record)),
            Tables\Actions\DeleteAction::make(),
        ];
    }

    public function render()
    {
        return view('livewire.maintenance-form');
    }
}
