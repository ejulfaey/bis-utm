<?php

namespace App\Filament\Pages;

use App\Models\Project;
use App\Models\Role;
use Filament\Tables;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;

class NewProject extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-folder-add';

    protected static string $view = 'filament.pages.new-project';

    protected static ?string $navigationLabel = 'Manage Projects';

    protected static ?string $slug = "new-projects";

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()->role_id, [Role::SUPERADMIN]);
    }

    protected function getTableQuery(): Builder
    {
        return Project::latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('user.name')
                ->label('Project Leader')
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

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('edit')
                ->url(fn (Project $record): string => route('new-projects.edit', $record)),
        ];
    }
}
