<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('password')
                ->label('Change Password')
                ->url(UserResource::getUrl('password')),
        ];
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return 'User has been updated';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['password']))
            $data['password'] = bcrypt($data['password']);
        else
            unset($data['password']);

        return $data;
    }
}
