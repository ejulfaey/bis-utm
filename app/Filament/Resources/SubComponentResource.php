<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubComponentResource\Pages;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubComponentResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $label = 'Sub Component';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $slug = 'sub-component';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute  = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereGroupId(Parameter::SUBCOMPONENT)
            ->orderBy('parent_id')
            ->orderBy('name');
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Component')
                    ->searchable()
                    ->sortable(),
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
                    ->successNotificationTitle('Sub component has been updated'),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Sub component has been deleted'),
                Tables\Actions\RestoreAction::make()
                    ->successNotificationTitle('Sub component has been restored'),
                Tables\Actions\ForceDeleteAction::make()
                    ->successNotificationTitle('Sub component has been destroyed'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubComponents::route('/'),
        ];
    }
}
