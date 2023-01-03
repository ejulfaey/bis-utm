<?php

namespace App\Filament\Resources\DefectResource\Pages;

use App\Filament\Resources\DefectResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDefects extends ManageRecords
{
    protected static string $resource = DefectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    $data['group_id'] = Parameter::DEFECT;
                    return $data;
                })
                ->successNotificationTitle('Defect has been created'),
        ];
    }
}
