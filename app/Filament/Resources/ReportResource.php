<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Calculator;
use App\Models\ConstructionCost;
use App\Models\Inspection;
use App\Models\MaintenanceCost;
use App\Models\Parameter;
use App\Models\Project;
use App\Models\RentalCost;
use App\Models\Report;
use App\Models\Role;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-report';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()->role_id, [Role::SUPERADMIN, Role::ADMIN]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Building Condition Assessments')
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->label('Project')
                            ->options(Project::orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                $project = Project::find($state);

                                if ($project) {

                                    $set('building_type', $project->building_type->name);
                                    $set('total_floor', $project->total_floor);

                                    $initial_cost = ConstructionCost::firstWhere('building_type_id', $project->building_type_id);
                                    $set('initial_cost', $initial_cost->total_cost);

                                    $codes = [
                                        'architectural',
                                        'structural',
                                        'building',
                                    ];

                                    $components = Parameter::select('id', 'name', 'value')
                                        ->whereGroupId(Parameter::COMPONENT)
                                        ->orderBy('name')
                                        ->get();

                                    $bca_score = 0;

                                    foreach ($components as $index => $component) {
                                        $inspects = Inspection::whereProjectId($state)
                                            ->whereComponentId($component->id)
                                            ->get();

                                        $total = $inspects->count() == 0 ? 1 : $inspects->count();
                                        $score = ($inspects->sum('total_matrix') / $total);
                                        $percent = round($score / 16 * $component->value, 2);
                                        $bca_score += $percent;

                                        $set($codes[$index] . '_score', $score);
                                        $set($codes[$index] . '_percent', $percent);
                                    }
                                    $set('bca_score', $bca_score);
                                    $classification = Parameter::whereGroupId(Parameter::CLASSIFICATION_BUILDING)
                                        ->whereRaw("? between `from` and `to`", [round($bca_score)])
                                        ->first();

                                    $set('classification', $classification->name);
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                $project = Project::find($state);

                                if ($project) {

                                    $set('building_type', $project->building_type->name);
                                    $set('total_floor', $project->total_floor);

                                    $initial_cost = ConstructionCost::firstWhere('building_type_id', $project->building_type_id);
                                    $set('initial_cost', $initial_cost->total_cost);

                                    $codes = [
                                        'architectural',
                                        'structural',
                                        'building',
                                    ];

                                    $components = Parameter::select('id', 'name', 'value')
                                        ->whereGroupId(Parameter::COMPONENT)
                                        ->orderBy('name')
                                        ->get();

                                    $bca_score = 0;

                                    foreach ($components as $index => $component) {
                                        $inspects = Inspection::whereProjectId($state)
                                            ->whereComponentId($component->id)
                                            ->get();

                                        $total = $inspects->count() == 0 ? 1 : $inspects->count();
                                        $score = ($inspects->sum('total_matrix') / $total);
                                        $percent = round($score / 16 * $component->value, 2);
                                        $bca_score += $percent;

                                        $set($codes[$index] . '_score', $score);
                                        $set($codes[$index] . '_percent', $percent);
                                    }
                                    $set('bca_score', $bca_score);
                                    $classification = Parameter::whereGroupId(Parameter::CLASSIFICATION_BUILDING)
                                        ->whereRaw("? between `from` and `to`", [round($bca_score)])
                                        ->first();

                                    $set('classification', $classification->name);
                                }
                            })
                            ->required(),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('area_of_building')
                                    ->numeric()
                                    ->helperText('In meter'),
                                Forms\Components\TextInput::make('building_type')
                                    ->label('Type of building')
                                    ->disabled(),
                                Forms\Components\TextInput::make('total_floor')
                                    ->label('No. of floor')
                                    ->disabled(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('structural_score')
                                    ->label('Structural Score')
                                    ->disabled(),
                                Forms\Components\TextInput::make('structural_percent')
                                    ->hint('Max: 22.22%')
                                    ->label('Structural Percentage (%)')
                                    ->disabled(),
                                Forms\Components\TextInput::make('architectural_score')
                                    ->label('Architectural Score')
                                    ->disabled(),
                                Forms\Components\TextInput::make('architectural_percent')
                                    ->label('Architectural Percentage (%)')
                                    ->hint('Max: 66.67%')
                                    ->disabled(),
                                Forms\Components\TextInput::make('building_score')
                                    ->label('Building Service Score')
                                    ->disabled(),
                                Forms\Components\TextInput::make('building_percent')
                                    ->label('Building Service Percentage (%)')
                                    ->hint('Max: 11.11%')
                                    ->disabled(),
                                Forms\Components\TextInput::make('bca_score')
                                    ->label('BCA Score (%)')
                                    ->reactive()
                                    ->disabled(),
                                Forms\Components\TextInput::make('classification')
                                    ->label('Building Classification')
                                    ->disabled(),
                            ]),
                    ]),
                Forms\Components\Section::make('Life Cycle Cost Analysis')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('maintenance_cost')
                                    ->label('Cost of maintenance (RM)')
                                    ->afterStateHydrated(function (callable $set) {

                                        $cost = MaintenanceCost::sum('total_cost');
                                        $set('maintenance_cost', $cost);
                                    })
                                    ->disabled(),
                                Forms\Components\TextInput::make('time_period')
                                    ->label('Time Period, t')
                                    ->integer()
                                    ->helperText('In Years')
                                    ->reactive()
                                    ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                        if (!$state) {
                                            $set('npv_maintenance', '');
                                            $set('energy_usage', '');
                                            $set('water_usage', '');
                                            $set('rental_value', '');
                                            $set('lcca', '');
                                        }

                                        if ($state && $get('discount_rate')) {
                                            $npv = $get('maintenance_cost') * pow((1 + $get('discount_rate')), (-$state));
                                            $set('npv_maintenance', $npv);
                                        }

                                        if ($state) {
                                            $calculator = Calculator::find(1);
                                            $energy_usage = $calculator->yearly_electrical_cost * $state;
                                            $water_usage = $calculator->yearly_water_cost * $state;
                                            $rental_value = RentalCost::find(1)->cost_room;

                                            $set('energy_usage', $energy_usage);
                                            $set('water_usage', $water_usage);
                                            $set('rental_value', $rental_value);

                                            $lcca = $get('initial_cost') + $get('npv_maintenance') + $get('energy_usage')
                                                + $get('water_usage') + $get('rental_value');

                                            $set('lcca', round($lcca, 2));
                                        }
                                    })
                                    ->afterStateUpdated(function (callable $get, callable $set, $state) {

                                        if (!$state) {
                                            $set('npv_maintenance', '');
                                            $set('energy_usage', '');
                                            $set('water_usage', '');
                                            $set('rental_value', '');
                                            $set('lcca', '');
                                        }

                                        if ($state && $get('discount_rate')) {
                                            $npv = $get('maintenance_cost') * pow((1 + $get('discount_rate')), (-$state));
                                            $set('npv_maintenance', $npv);
                                        }

                                        if ($state) {
                                            $calculator = Calculator::find(1);
                                            $energy_usage = $calculator->yearly_electrical_cost * $state;
                                            $water_usage = $calculator->yearly_water_cost * $state;
                                            $rental_value = RentalCost::find(1)->cost_room;

                                            $set('energy_usage', $energy_usage);
                                            $set('water_usage', $water_usage);
                                            $set('rental_value', $rental_value);

                                            $lcca = $get('initial_cost') + $get('npv_maintenance') + $get('energy_usage')
                                                + $get('water_usage') + $get('rental_value');

                                            $set('lcca', round($lcca, 2));
                                        }
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('discount_rate')
                                    ->label('Discount rate (%)')
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $get, callable $set, $state) {

                                        if ($state && $get('time_period')) {
                                            $npv = $get('maintenance_cost') * pow((1 + $state), (-$get('time_period')));
                                            $set('npv_maintenance', $npv);
                                        }
                                    })
                                    ->required(),
                            ]),
                        Forms\Components\TextInput::make('npv_maintenance')
                            ->label('NPV of maintenance cost (RM)')
                            ->disabled(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('initial_cost')
                                    ->label('Initial Cost of Construction, CI (RM)')
                                    ->disabled(),
                                Forms\Components\TextInput::make('energy_usage')
                                    ->label('Energy usage cost (RM)')
                                    ->disabled(),
                                Forms\Components\TextInput::make('water_usage')
                                    ->label('Water usage cost (RM)')
                                    ->disabled(),
                                Forms\Components\TextInput::make('rental_value')
                                    ->label('Rental Value (RM)')
                                    ->disabled(),
                            ]),
                        Forms\Components\TextInput::make('lcca')
                            ->label('Life Cycle Cost Analysis, LCCA (RM)')
                            ->disabled(),
                        Forms\Components\Textarea::make('summary'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Building/Block'),
                Tables\Columns\TextColumn::make('project.building_type.name')
                    ->label('Type of building'),
                Tables\Columns\TextColumn::make('bca_score')
                    ->label('BCA Score(%)'),
                Tables\Columns\TextColumn::make('classification.name')
                    ->label('Classification'),
                Tables\Columns\TextColumn::make('lcca')
                    ->label('Life Cycle Cost Analysis, LCCA'),
                Tables\Columns\TextColumn::make('summary'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Update')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
