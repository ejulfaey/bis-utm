<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionResource\Pages;
use App\Filament\Resources\InspectionResource\RelationManagers;
use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Filament\Tables;

class InspectionResource extends Resource
{

    protected static ?string $model = Inspection::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = false;

    public static function table(Table $table): Table
    {
        return $table
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
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('classification.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Project Info')
                    ->description('Description')
                    ->schema([
                        Forms\Components\TextInput::make('project')
                            ->label('Project')
                            ->default(function () {
                                $project = Project::find(request()->query('ownerRecord'));
                                return $project?->name;
                            })
                            ->afterStateHydrated(function (callable $set, ?Model $record, Component $livewire) {
                                if ($livewire instanceof Pages\EditInspection) {
                                    $set('project', $record?->project->name);
                                }
                            })
                            ->columnSpanFull()
                            ->disabled(true)
                            ->hiddenOn('create'),
                        Forms\Components\Select::make('project')
                            ->label('Project')
                            ->options(Project::pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $project = Project::find($state);
                            })
                            ->searchable()
                            ->columnSpanFull()
                            ->hiddenOn('edit')
                            ->required(),
                        Forms\Components\TextInput::make('assessor')
                            ->label('Project Leader')
                            ->default(function () {
                                $project = Project::find(request()->query('ownerRecord'));
                                return $project?->user?->name;
                            })
                            ->afterStateHydrated(function (callable $set, ?Model $record, Component $livewire) {
                                if ($livewire instanceof Pages\EditInspection)
                                    $set('assessor', $record?->project->user->name);
                            })
                            ->disabled(true),
                        Forms\Components\TextInput::make('college_block')
                            ->label('College/Block')
                            ->default(function () {
                                $project = Project::find(request()->query('ownerRecord'));
                                return $project?->college_block;
                            })
                            ->afterStateHydrated(function (callable $set, ?Model $record, Component $livewire) {
                                if ($livewire instanceof Pages\EditInspection)
                                    $set('college_block', $record?->project->college_block);
                            })
                            ->disabled(true),
                        Forms\Components\TextInput::make('total_floor')
                            ->default(function () {
                                $project = Project::find(request()->query('ownerRecord'));
                                return $project?->total_floor;
                            })
                            ->afterStateHydrated(function (callable $set, ?Model $record, Component $livewire) {
                                if ($livewire instanceof Pages\EditInspection)
                                    $set('total_floor', $record?->project->total_floor);
                            })
                            ->disabled(true),
                        Forms\Components\FileUpload::make('plan_attachment')
                            ->label('Drawing Plan')
                            ->afterStateHydrated(function (?Model $record, callable $set) {
                                if ($record) {
                                    $set('plan_attachment', [$record?->project->plan_attachment]);
                                } else {
                                    $project = Project::find(request()->query('ownerRecord'));
                                    if ($project) $set('plan_attachment', [$project->plan_attachment]);
                                }
                            })
                            ->columnSpanFull()
                            ->disabled(true),

                    ])
                    ->collapsed(false)
                    ->columns(3),
                Section::make('BCA Inventory')
                    ->description('Component')
                    ->schema([
                        Grid::make(4)
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
                                Forms\Components\TextInput::make('user.name')
                                    ->label('Assessor')
                                    ->hiddenOn('create')
                                    ->afterStateHydrated(function (?Model $record, callable $set) {
                                        if ($record) $set('user.name', $record->user->name);
                                    })
                                    ->disabled(),
                                Forms\Components\TextInput::make('user_id')
                                    ->label('Assessor')
                                    ->default(auth()->user()->name)
                                    ->hiddenOn('edit')
                                    ->disabled(),
                            ]),
                        Grid::make(3)
                            ->schema([

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
                        Grid::make(3)
                            ->schema([
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
                                Forms\Components\Select::make('defect_id')
                                    ->label('Building Defect')
                                    ->options(Parameter::active()->whereGroupId(Parameter::DEFECT)->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                            ]),
                        Grid::make(2)
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
                                    ->options(Parameter::active()->whereGroupId(Parameter::SCORE_CONDITION)->pluck('value', 'id'))
                                    ->afterStateUpdated(function (callable $get, callable $set, $state) {
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
                                    ->tooltip(function () {
                                        $scores = Parameter::whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('name', 'value');
                                        $str = '';
                                        foreach ($scores as $key => $value) {
                                            $str .= $key . ' - ' . $value . ', ';
                                        }
                                        $str = rtrim($str, ', ');
                                        return $str;
                                    })
                                    ->options(Parameter::active()->whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('value', 'id'))
                                    ->afterStateUpdated(function (callable $get, callable $set, $state) {
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
            'show' => Pages\ViewInspection::route('/{record}/show'),
        ];
    }
}
