<?php

namespace App\Filament\Resources\InspectionResource\Pages;

use App\Filament\Resources\InspectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInspections extends ListRecords
{
    protected static string $resource = InspectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
