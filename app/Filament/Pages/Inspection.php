<?php

namespace App\Filament\Pages;

use App\Models\Inspection as ModelsInspection;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $view = 'filament.pages.inspection';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    protected ?string $heading = 'Manage Inspections';

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('New Inspection')
                ->icon('heroicon-o-plus')
                ->url(fn () => route('inspection.create')),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return ModelsInspection::with('project')->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('ID'),
            Tables\Columns\TextColumn::make('project.name')

                ->searchable()
                ->sortable(),
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
                ->alignCenter(),
            Tables\Columns\TextColumn::make('classification.name')
                ->sortable(),
            Tables\Columns\TextColumn::make('date')
                ->date(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('edit')
                ->url(fn (ModelsInspection $record): string => route('inspection.edit', $record)),
        ];
    }
}
