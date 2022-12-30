<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function () {
                    activity()->log('deleted');
                }),
        ];
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return 'User has been updated';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password'])
            $data['password'] = bcrypt($data['password']);
        else
            $data = Arr::except($data, ['password', 'password_confirmation']);

        activity()
            ->withProperties($data)
            ->log('edited');

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
