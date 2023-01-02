<?php

namespace App\Filament\Resources\InspectionResource\Pages;

use App\Filament\Resources\InspectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInspection extends EditRecord
{
    protected static string $resource = InspectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
