<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $label = 'Location';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?string $navigationLabel = 'Locations';

    protected static ?string $navigationIcon = 'heroicon-o-location-marker';

    protected static ?string $slug = 'locations';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute  = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereGroupId(Parameter::LOCATION)
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
                        0 => 'In-Active'
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
                    ->successNotificationTitle('Location has been updated'),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Location has been deleted'),
                Tables\Actions\RestoreAction::make()
                    ->successNotificationTitle('Location has been restored'),
                    Tables\Actions\ForceDeleteAction::make()
                    ->successNotificationTitle('Location has been destroyed'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLocations::route('/'),
        ];
    }
}
