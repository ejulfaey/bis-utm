<?php

namespace App\Filament\Pages;

use App\Forms\Components\PhotoSlider;
use App\Http\Livewire\LivewireChart;
use App\Models\Inspection as ModelsInspection;
use App\Models\Parameter;
use App\Models\Project;
use App\Traits\PrintTrait;
use Closure;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class Inspection extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable, PrintTrait;

    protected static string $view = 'filament.pages.inspection';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    protected ?string $heading = 'Manage Inspections';

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('New Inspection')
                ->icon('heroicon-o-plus')
                ->url(fn () => route('inspection.create')),
            // Action::make('print')
            //     ->icon('heroicon-o-printer')
            //     ->url(fn () => route('report.inspection')),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return ModelsInspection::with('project')->latest();
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Model $record): string => route('inspection.edit', $record);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('ID'),
            Tables\Columns\TextColumn::make('project.name')

                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('project.college_block')
                ->label('Name College')
                ->description(fn (Model $record): ?string => $record->user->name)
                ->searchable()
                ->sortable(),
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

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('edit')
                ->url(fn (ModelsInspection $record): string => route('inspection.edit', $record)),
            Tables\Actions\ViewAction::make()
                ->form([
                    Forms\Components\Section::make('Project Info')
                        ->description('Project description')
                        ->schema([
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\DatePicker::make('date'),
                                    Forms\Components\Select::make('weather_id')
                                        ->label('Weather')
                                        ->options(Parameter::active()->whereGroupId(Parameter::WEATHER)->pluck('name', 'id')),
                                    Forms\Components\TextInput::make('floor_no')
                                        ->label('Floor No.'),
                                    Forms\Components\TextInput::make('unit_no')
                                        ->label('Unit No.'),
                                    Forms\Components\TextInput::make('grid_no')
                                        ->label('Grid No.'),
                                    Forms\Components\Select::make('location_id')
                                        ->label('Location')
                                        ->options(Parameter::active()->whereGroupId(Parameter::LOCATION)->pluck('name', 'id'))
                                        ->required(),
                                ]),
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\Select::make('component_id')
                                        ->label('Component')
                                        ->options(Parameter::active()->whereGroupId(Parameter::COMPONENT)->pluck('name', 'id')),
                                    Forms\Components\Select::make('sub_component_id')
                                        ->label('Sub Component')
                                        ->options(function (callable $get) {
                                            if ($get('component_id')) {
                                                return Parameter::whereParentId($get('component_id'))->pluck('name', 'id');
                                            }
                                        }),
                                    Forms\Components\Select::make('defect_id')
                                        ->label('Building Defect')
                                        ->options(Parameter::active()->whereGroupId(Parameter::DEFECT)->pluck('name', 'id')),
                                ]),
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\Select::make('condition_score_id')
                                        ->label('Condition Score')
                                        ->tooltip(function () {
                                            $scores = Parameter::whereGroupId(Parameter::SCORE_CONDITION)->pluck('name', 'value');
                                            $str = '';
                                            foreach ($scores as $key => $value) {
                                                $str .= $key . ' - ' . $value . ', ';
                                            }
                                            $str = rtrim($str, ', ');
                                            return $str;
                                        })
                                        ->options(Parameter::active()->whereGroupId(Parameter::SCORE_CONDITION)->pluck('value', 'id')),
                                    Forms\Components\Select::make('maintenance_score_id')
                                        ->label('Maintenance Score')
                                        ->tooltip(function () {
                                            $scores = Parameter::whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('name', 'value');
                                            $str = '';
                                            foreach ($scores as $key => $value) {
                                                $str .= $key . ' - ' . $value . ', ';
                                            }
                                            $str = rtrim($str, ', ');
                                            return $str;
                                        })
                                        ->options(Parameter::active()->whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('value', 'id')),
                                    Forms\Components\TextInput::make('total_matrix')
                                        ->afterStateHydrated(function (Model $record, callable $set) {
                                            $set('total_matrix', $record->total_matrix);
                                        }),
                                    Forms\Components\Select::make('classification_id')
                                        ->label('Classification')
                                        ->options(Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->pluck('name', 'id')),
                                ]),
                            Forms\Components\Textarea::make('remark')
                                ->columnSpan('full'),
                            PhotoSlider::make('photos')
                                ->afterStateHydrated(function (Model $record, callable $set) {
                                    $set('photos', $record->photos->pluck('photo')->toArray());
                                    // $set('photos', $record->photos->plucjtoArray());
                                })
                                ->columnSpanFull(),
                        ]),
                ]),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('print')
                ->action(fn (Collection $records) => $this->printInspection($records)),
        ];
    }

    protected function getTableFilters(): array
    {
        $projects = Project::orderBy('name')
            ->get()
            ->map(function ($project) {
                return Filter::make(Str::slug($project->name))
                    ->label($project->name)
                    ->query(fn (Builder $query): Builder => $query->whereProjectId($project->id));
            })
            ->toArray();

        return [
            ...$projects,
        ];
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }
}
