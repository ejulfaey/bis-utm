<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubComponentResource\Pages;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubComponentResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $label = 'Sub Components';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $slug = 'sub-component';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereGroupId(Parameter::SUBCOMPONENT);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->label('Component')
                    ->options(Parameter::whereGroupId(Parameter::COMPONENT)->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('name')
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
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Component'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubComponents::route('/'),
        ];
    }
}
