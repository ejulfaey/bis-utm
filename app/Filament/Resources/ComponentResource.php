<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComponentResource\Pages;
use App\Filament\Resources\ComponentResource\RelationManagers;
use App\Models\Parameter;
use App\Models\Role;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComponentResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $label = 'Components';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?string $navigationLabel = 'Components';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $slug = 'component';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereGroupId(Parameter::COMPONENT);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->columnSpan('full')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->successNotificationTitle('Component has been updated'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageComponents::route('/'),
        ];
    }
}
