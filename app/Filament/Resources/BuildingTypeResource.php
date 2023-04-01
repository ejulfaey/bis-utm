<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BuildingTypeResource\Pages;
use App\Filament\Resources\BuildingTypeResource\RelationManagers;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BuildingTypeResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $label = 'Building Types';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    protected static ?string $slug = 'building-types';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute  = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereGroupId(Parameter::BUILDING_TYPE)
            ->orderBy('name');
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true)
                    ->required(),
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
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('is_active')
                    ->label('Active')
                    ->enum([
                        1 => 'Active',
                        0 => 'In-active'
                    ])
                    ->colors([
                        'success' => 1,
                        'warning' => 0,
                    ])
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->successNotificationTitle('Building type has been updated'),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Building type has been deleted'),
                Tables\Actions\RestoreAction::make()
                    ->successNotificationTitle('Building type has been restored'),
                Tables\Actions\ForceDeleteAction::make()
                    ->successNotificationTitle('Building type has been destroyed'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBuildingTypes::route('/'),
        ];
    }
}
