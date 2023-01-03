<?php

namespace App\Filament\Resources\SubComponentResource\Pages;

use App\Filament\Resources\SubComponentResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubComponents extends ManageRecords
{
    protected static string $resource = SubComponentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    $data['group_id'] = Parameter::SUBCOMPONENT;
                    return $data;
                }),
        ];
    }
}
