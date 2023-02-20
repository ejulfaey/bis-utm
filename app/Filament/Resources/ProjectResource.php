<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Parameter;
use App\Models\Project;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?int $navigationSort = 1;

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
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('user.name')
                            ->label('Project Leader')
                            ->default(auth()->user()->name)
                            ->afterStateHydrated(function (callable $set) {
                                $set('user.name', auth()->user()->name);
                            })
                            ->disabled(true),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('building_type_id')
                                    ->label('Building Type')
                                    ->options(Parameter::whereGroupId(Parameter::BUILDING_TYPE)->pluck('name', 'id'))
                                    ->required(),
                                Forms\Components\TextInput::make('college_block')
                                    ->label('College/Block')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('total_floor')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('area_of_building')
                                    ->label('Area of Building (m2)')
                                    ->numeric()
                                    ->required(),
                            ]),
                        Forms\Components\FileUpload::make('plan_attachment')
                            ->label('Drawing Plan')
                            ->directory('plans')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->maxSize(10240)
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return (string) str(date('dmyhis') . '.' . $file->extension())->prepend('plan-');
                            })
                            ->helperText('Maximum size is 10MB')
                            ->columnSpan('full'),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Assessor')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('building_type.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_floor'),
                Tables\Columns\TextColumn::make('inspections_count')
                    ->counts('inspections')
                    ->label('Total Inspection(s)')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Update')
                    ->description(fn (Project $record): string => 'Since: ' . $record->created_at->format('d M Y'))
                    ->sortable()
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
                FilamentExportBulkAction::make('export'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\InspectionsRelationManager::class,
            RelationManagers\InspectionArchitecturalRelationManager::class,
            RelationManagers\InspectionStructuralRelationManager::class,
            RelationManagers\InspectionBuildingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
