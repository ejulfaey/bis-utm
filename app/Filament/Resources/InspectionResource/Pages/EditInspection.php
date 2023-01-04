<?php

namespace App\Filament\Resources\InspectionResource\Pages;

use App\Filament\Resources\InspectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditInspection extends EditRecord
{
    protected static string $resource = InspectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = Arr::except($data, ['project', 'assessor', 'college_block', 'total_floor', 'total_matrix', 'classification']);
        return $data;
    }


    protected function getSavedNotificationMessage(): ?string
    {
        return "Inspection has been saved";
    }
}
