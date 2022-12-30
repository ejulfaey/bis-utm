<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Main';

    protected static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()->role_id, [Role::SUPERADMIN, Role::ADMIN]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\FileUpload::make('plan_attachment')
                            ->label('Drawing Plan')
                            ->directory('plans')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->maxSize(10240)
                            ->panelAspectRatio('4:1')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return (string) str(date('dmyhis') . '.' . $file->extension())->prepend('plan-');
                            })
                            ->helperText('Maximum size is 10MB'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('inspections_count')
                    ->counts('inspections')
                    ->label('Total Inspection(s)')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
