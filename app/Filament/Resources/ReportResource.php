<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Project;
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
                            ->afterStateUpdated(function ($state, callable $set) {
                                $project = Project::find($state);
                                $set('building_type_id', $project->building_type->name);
                                $set('total_floor', $project->total_floor);

                                // $set('architectural_score', $project->total_floor);
                                // $set('building_score', $project->total_floor);
                            })
                            ->required(),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('area_of_building')
                                    ->numeric()
                                    ->required()
                                    ->reactive(),
                                Forms\Components\TextInput::make('building_type_id')
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
                                    ->label('Classification')
                                    ->disabled(),
                            ]),
                    ]),
                Forms\Components\Section::make('Life Cycle Cost Analysis')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('maintenace_cost')
                                    ->label('Cost of maintenance (RM)')
                                    ->disabled(),
                                Forms\Components\TextInput::make('time_period')
                                    ->label('Time Period, t')
                                    ->hint('in days')
                                    ->numeric()
                                    ->reactive()
                                    ->required(),
                                Forms\Components\TextInput::make('discount_rate')
                                    ->label('Discount rate (%)')
                                    ->numeric()
                                    ->reactive()
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
