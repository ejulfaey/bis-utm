<?php

namespace App\Filament\Pages\Project;

use App\Models\Project;
use Filament\Widgets\TableWidget as PageWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Forms;

class ListProject extends PageWidget
{

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getTableQuery(): Builder
    {
        return Project::query();
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\CreateAction::make()
                ->label('Create Project')
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->maxLength(255)
                        ->required(),
                ]),

        ];
    }

    protected function getTableColumns(): array
    {
        return [
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
        ];
    }
}
