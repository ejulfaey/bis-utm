<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionResource\Pages;
use App\Filament\Resources\InspectionResource\RelationManagers;
use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Project;
use App\Models\Role;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Project Info')
                    ->description('Description')
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->label('Project')
                            ->options(Project::all()->pluck('name', 'id'))
                            ->placeholder('Select a project')
                            ->searchable()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                if ($state) {
                                    $project = Project::find($state);
                                    $set('college_block', $project->college_block);
                                    $set('assessor', $project->user->name);
                                } else {
                                    $set('college_block', null);
                                    $set('assessor', null);
                                }
                            })
                            ->reactive()
                            ->disabledOn('edit')
                            ->columnSpan('full')
                            ->required(),
                        Forms\Components\TextInput::make('assessor')
                            ->label('Assessor')
                            ->afterStateHydrated(function (callable $get, callable $set) {
                                $project = Project::find($get('project_id'));
                                if ($project) $set('assessor', $project->user->name);
                            })
                            ->hiddenOn('create')
                            ->disabled(true),
                        Forms\Components\TextInput::make('assessor')
                            ->label('Assessor')
                            ->hiddenOn('edit')
                            ->disabled(true),
                        Forms\Components\TextInput::make('college_block')
                            ->label('College/Block')
                            ->afterStateHydrated(function (callable $get, callable $set) {
                                $project = Project::find($get('project_id'));
                                if ($project) $set('college_block', $project->college_block);
                            })
                            ->disabled(true),

                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('BCA Inventory')
                    ->description('Component')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('date')
                                    ->maxDate(today()->addDay())
                                    ->default(today())
                                    ->required(),
                                Forms\Components\Select::make('weather_id')
                                    ->label('Weather')
                                    ->options(Parameter::active()->whereGroupId(Parameter::WEATHER)->pluck('name', 'id'))
                                    ->required(),
                                Forms\Components\TextInput::make('floor_no')
                                    ->label('Floor No.')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('unit_no')
                                    ->label('Unit No.')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('grid_no')
                                    ->label('Grid No.')
                                    ->maxLength(255),
                                Forms\Components\Select::make('location_id')
                                    ->label('Location')
                                    ->options(Parameter::active()->whereGroupId(Parameter::LOCATION)->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                            ]),
                        Forms\Components\Select::make('component_id')
                            ->label('Component')
                            ->options(Parameter::active()->whereGroupId(Parameter::COMPONENT)->pluck('name', 'id'))
                            ->reactive()
                            ->required(),
                        Forms\Components\Select::make('sub_component_id')
                            ->label('Sub Component')
                            ->options(function (callable $get) {

                                if ($get('component_id')) {
                                    return Parameter::whereParentId($get('component_id'))->pluck('name', 'id');
                                }
                            })
                            ->searchable()
                            ->required(),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('defect_id')
                                    ->label('Building Defect')
                                    ->options(Parameter::active()->whereGroupId(Parameter::DEFECT)->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                                Forms\Components\Select::make('condition_score_id')
                                    ->label('Condition Score')
                                    ->options(Parameter::active()->whereGroupId(Parameter::SCORE_CONDITION)->pluck('value', 'id'))
                                    ->afterStateUpdated(function (Closure $get, Closure $set, $state) {
                                        if ($get('maintenance_score_id') && $state != null) {
                                            $matrix = Parameter::find($state)->value * Parameter::find($get('maintenance_score_id'))->value;
                                            $classification = Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->whereRaw('? between `from` and `to`', $matrix)
                                                ->first();
                                            $set('total_matrix', $matrix);
                                            $set('classification', $classification->name);
                                        }
                                        if ($state == null) {
                                            $set('total_matrix', null);
                                            $set('classification', null);
                                        }
                                    })
                                    ->reactive()
                                    ->required(),
                                Forms\Components\Select::make('maintenance_score_id')
                                    ->label('Maintenance Score')
                                    ->options(Parameter::active()->whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('value', 'id'))
                                    ->afterStateUpdated(function (Closure $get, Closure $set, $state) {
                                        if ($get('condition_score_id') && $state != null) {
                                            $matrix = Parameter::find($state)->value * Parameter::find($get('condition_score_id'))->value;
                                            $classification = Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->whereRaw('? between `from` and `to`', $matrix)
                                                ->first();
                                            $set('total_matrix', $matrix);
                                            $set('classification', $classification->name);
                                        }
                                        if ($state == null) {
                                            $set('total_matrix', null);
                                            $set('classification', null);
                                        }
                                    })
                                    ->reactive()
                                    ->required(),
                            ]),
                        Forms\Components\TextInput::make('total_matrix')
                            ->disabled(true)
                            ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                if ($get('condition_score_id') && $get('maintenance_score_id')) {
                                    $score = Parameter::whereIn('id', [$get('condition_score_id'), $get('maintenance_score_id')])->get();
                                    $matrix = $score->firstWhere('id', $get('condition_score_id'))->value * $score->firstWhere('id', $get('maintenance_score_id'))->value;
                                    $set('total_matrix', $matrix);
                                }
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('classification')
                            ->disabled(true)
                            ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                if ($get('condition_score_id') && $get('maintenance_score_id')) {
                                    $score = Parameter::whereIn('id', [$get('condition_score_id'), $get('maintenance_score_id')])->get();
                                    $matrix = $score->firstWhere('id', $get('condition_score_id'))->value * $score->firstWhere('id', $get('maintenance_score_id'))->value;
                                    $classification = Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->whereRaw('? between `from` and `to`', $matrix)
                                        ->first();
                                    $set('classification', $classification->name);
                                }
                            })
                            ->reactive(),
                        Forms\Components\Textarea::make('remark')
                            ->columnSpan('full')
                            ->maxLength(65535),
                    ])->columns([
                        'sm' => 1,
                        'md' => 2,
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
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
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classification.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInspections::route('/'),
            'create' => Pages\CreateInspection::route('/create'),
            'edit' => Pages\EditInspection::route('/{record}/edit'),
        ];
    }
}
