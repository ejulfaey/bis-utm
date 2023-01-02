<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionResource\Pages;
use App\Filament\Resources\InspectionResource\RelationManagers;
use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Project;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

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
                            ->required(),
                        Forms\Components\TextInput::make('assessor_id')
                            ->label('Assessor')
                            ->default(auth()->user()->name)
                            ->disabled(true),
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('Component Info')
                    ->description('Description')
                    ->schema([
                        Grid::make(5)
                            ->schema([
                                Forms\Components\DatePicker::make('date')
                                    ->required(),
                                Forms\Components\Select::make('weather_id')
                                    ->label('Weather')
                                    ->options(Parameter::whereGroupId(Parameter::WEATHER)->pluck('name', 'id'))
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
                            ]),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('location_id')
                            ->label('Location')
                            ->options(Parameter::whereGroupId(Parameter::LOCATION)->pluck('name', 'id'))
                            ->required(),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('component_id')
                                    ->label('Component')
                                    ->options(Parameter::whereGroupId(Parameter::COMPONENT)->pluck('name', 'id'))
                                    ->required(),
                                Forms\Components\Select::make('sub_component_id')
                                    ->label('Sub Component')
                                    ->options(Parameter::whereGroupId(Parameter::SUBCOMPONENT)->pluck('name', 'id')),
                                Forms\Components\Select::make('defect_id')
                                    ->label('Building Defect')
                                    ->options(Parameter::whereGroupId(Parameter::DEFECT)->pluck('name', 'id'))
                                    ->required(),
                                Forms\Components\Select::make('condition_score_id')
                                    ->label('Condition Score')
                                    ->options(Parameter::whereGroupId(Parameter::SCORE_CONDITION)->pluck('value', 'id'))
                                    ->afterStateUpdated(function (Closure $get, Closure $set, $state) {
                                        if ($get('maintenance_score_id') && $state != null) {
                                            $matrix = Parameter::find($state)->value * Parameter::find($get('maintenance_score_id'))->value;
                                            $set('total_matrix', $matrix);
                                        }
                                        if ($state == null) {
                                            $set('total_matrix', null);
                                        }
                                    })
                                    ->reactive()
                                    ->required(),
                                Forms\Components\Select::make('maintenance_score_id')
                                    ->label('Maintenance Score')
                                    ->options(Parameter::whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('value', 'id'))
                                    ->afterStateUpdated(function (Closure $get, Closure $set, $state) {
                                        if ($get('condition_score_id') && $state != null) {
                                            $matrix = Parameter::find($state)->value * Parameter::find($get('condition_score_id'))->value;
                                            $set('total_matrix', $matrix);
                                        }
                                        if ($state == null) {
                                            $set('total_matrix', null);
                                        }
                                    })
                                    ->reactive()
                                    ->required(),
                            ]),
                        Forms\Components\TextInput::make('total_matrix')
                            ->disabled(true)
                            ->reactive(),
                        Forms\Components\TextInput::make('total_matrix')
                            ->disabled(true)
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
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->description(function (Model $record): string {
                        return $record->assessor->name;
                    }),
                Tables\Columns\TextColumn::make('component.name')
                    ->description(function (Model $record): string {
                        return $record->subcomponent->name;
                    }),
                Tables\Columns\TextColumn::make('matrix')
                    ->label('Total Matrix'),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListInspections::route('/'),
            'create' => Pages\CreateInspection::route('/create'),
            'edit' => Pages\EditInspection::route('/{record}/edit'),
        ];
    }
}
