<?php

namespace App\Filament\Resources\InspectionResource\RelationManagers;

use App\Models\InspectionPhoto;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $recordTitleAttribute = 'photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->directory('photos')
                    ->maxSize(5120)
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str(date('dmyhis') . '.' . $file->extension())->prepend('photo-');
                    })
                    ->helperText('Maximum size is 10MB')
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->columnSpan('full')
                    ->default(function(Component $livewire) {

                        $id = InspectionPhoto::whereInspectionId($livewire->ownerRecord->id)
                        ->oldest()
                        ->first();

                        return 'Description ' . $id->id++;

                    })
                    ->maxLength(255)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->width('auto')
                    ->height(100),
                Tables\Columns\TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
