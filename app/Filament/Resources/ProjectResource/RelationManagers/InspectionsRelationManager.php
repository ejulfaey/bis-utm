<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\InspectionResource;
use App\Models\Parameter;
use App\Models\Project;

class InspectionsRelationManager extends RelationManager
{
    public Model $ownerRecord;

    protected static string $relationship = 'inspections';

    protected static ?string $recordTitleAttribute = 'name';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('project.college_block')
                    ->label('Name College')
                    ->description(fn (Model $record): ?string => $record->user->name)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('component.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subcomponent.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_matrix')
                    ->label('Total Matrix')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classification.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->url(fn ($livewire) => InspectionResource::getUrl('create', ['ownerRecord' => $livewire->ownerRecord->getKey()]))
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (Model $record) => InspectionResource::getUrl('edit', $record))
                    ->successNotificationTitle('Inspection has been updated'),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Inspection has been deleted'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->successNotificationTitle('Inspection has been deleted'),
                FilamentExportBulkAction::make('export'),
            ])
            ->defaultSort('date', 'desc');
    }
}
