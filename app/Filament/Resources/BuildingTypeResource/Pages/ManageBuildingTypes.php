<?php

namespace App\Filament\Resources\BuildingTypeResource\Pages;

use App\Filament\Resources\BuildingTypeResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBuildingTypes extends ManageRecords
{
    protected static string $resource = BuildingTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    $data['group_id'] = Parameter::BUILDING_TYPE;
                    return $data;
                })
                ->successNotificationTitle('Building type has been created'),
        ];
    }
}
