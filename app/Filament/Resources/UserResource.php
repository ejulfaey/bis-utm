<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Admin Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->columnSpan(1)
                                    ->maxLength(255)
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->columnSpan(1)
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                                Forms\Components\TextInput::make('password')
                                    ->columnSpan(1)
                                    ->autocomplete('new-password')
                                    ->password()
                                    ->confirmed()
                                    ->minLength(8)
                                    ->helperText('Minimum length is 8 characters')
                                    ->required(fn (Component $livewire): bool => $livewire instanceof Pages\CreateUser),
                                Forms\Components\TextInput::make('password_confirmation')
                                    ->label('Re-type Password')
                                    ->columnSpan(1)
                                    ->password()
                                    ->helperText('Must be same as Password')
                                    ->required(fn (Component $livewire): bool => $livewire instanceof Pages\CreateUser),
                                Forms\Components\Select::make('role_id')
                                    ->label('Role')
                                    ->placeholder('Select role')
                                    ->options(function () {
                                        $role = auth()->user()->role_id;
                                        return Role::when($role == Role::SUPERADMIN, function ($query, $role) {
                                            $query->whereIn('id', [Role::SUPERADMIN, Role::ADMIN, Role::NORMAL]);
                                        }, function ($query) {
                                            $query->whereIn('id', [Role::ADMIN, Role::NORMAL]);
                                        })->get()->pluck('name', 'id');
                                    })
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(fn (User $record): string => $record->email)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date("M d, Y H:i")
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make('edit')
                    ->label('Edit'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
