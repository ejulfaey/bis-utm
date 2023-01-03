<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DefectResource\Pages;
use App\Filament\Resources\DefectResource\RelationManagers;
use App\Models\Defect;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DefectResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $label = 'Defect';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?string $navigationLabel = 'Defects';

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    protected static ?string $slug = 'defects';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute  = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereGroupId(Parameter::DEFECT)
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
                    ->successNotificationTitle('Defect has been updated'),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Defect has been deleted'),
                Tables\Actions\RestoreAction::make()
                    ->successNotificationTitle('Defect has been restored'),
                Tables\Actions\ForceDeleteAction::make()
                    ->successNotificationTitle('Defect has been destroyed'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDefects::route('/'),
        ];
    }
}
