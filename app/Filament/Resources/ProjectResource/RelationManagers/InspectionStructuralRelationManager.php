<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InspectionStructuralRelationManager extends RelationManager
{
    protected static string $relationship = 'inspection_structural';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('component')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.college_block')
                    ->label('Name College')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subcomponent.name')
                    ->label('Sub Component')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_matrix')
                    ->label('Total Matrix')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classification.name')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}
