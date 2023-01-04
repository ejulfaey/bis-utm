<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Project;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class InspectionStructuralRelationManager extends RelationManager
{
    protected static string $relationship = 'inspection_structural';

    protected static ?string $title = 'Structural Components';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Project Info')
                    ->description('Description')
                    ->schema([
                        Forms\Components\Select::make('project')
                            ->label('Project')
                            ->relationship('project', 'name')
                            ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                $project = Project::find($state);
                                $model = Inspection::find($get('id'));

                                $set('assessor', $project->user->name);
                                $set('college_block', $project->college_block);
                                $set('condition_score', $model->condition_score->value);
                                $set('maintenance_score', $model->maintenance_score->value);
                                $set('total_matrix', $model->total_matrix);
                                $set('classification', $model->classification->name);
                            })
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('assessor')
                            ->label('Assessor'),
                        Forms\Components\TextInput::make('college_block')
                            ->label('College/Block'),
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('BCA Inventory')
                    ->description('Component')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('date'),
                                Forms\Components\Select::make('weather')
                                    ->label('Weather')
                                    ->relationship('weather', 'name'),
                                Forms\Components\TextInput::make('floor_no')
                                    ->label('Floor No.'),
                                Forms\Components\TextInput::make('unit_no')
                                    ->label('Unit No.'),
                                Forms\Components\TextInput::make('grid_no')
                                    ->label('Grid No.'),
                                Forms\Components\Select::make('location')
                                    ->label('Location')
                                    ->relationship('location', 'name'),
                            ]),
                        Forms\Components\Select::make('component')
                            ->label('Component')
                            ->relationship('component', 'name'),
                        Forms\Components\Select::make('subcomponent')
                            ->label('Sub Component')
                            ->relationship('subcomponent', 'name'),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('defect')
                                    ->label('Building Defect')
                                    ->relationship('defect', 'name'),
                                Forms\Components\TextInput::make('condition_score')
                                    ->label('Condition Score'),
                                Forms\Components\TextInput::make('maintenance_score')
                                    ->label('Maintenance Score'),
                            ]),
                        Forms\Components\TextInput::make('total_matrix'),
                        Forms\Components\TextInput::make('classification'),
                        Forms\Components\Textarea::make('remark')
                            ->columnSpan('full'),
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
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('project.college_block')
                    ->label('Name College')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subcomponent.name')
                    ->label('Sub Component')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_matrix')
                    ->label('Total Matrix')
                    ->sortable(),
                Tables\Columns\TextColumn::make('classification.name')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export'),
            ]);
    }

    protected function getTableContentFooter(): ?View
    {
        $inspect = Inspection::whereComponentId(Parameter::COMP_STRUCTURAL)
            ->get();

        return view('inspection.summary', [
            'total_matrix' => $inspect->sum('total_matrix'),
            'total_defect' => $inspect->count(),
            'overall' => number_format($inspect->sum('total_matrix') / $inspect->count(), 2),
        ]);
    }
}