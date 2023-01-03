<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLocations extends ManageRecords
{
    protected static string $resource = LocationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    $data['group_id'] = Parameter::LOCATION;
                    return $data;
                })
                ->successNotificationTitle('Location has been created'),
        ];
    }
}
