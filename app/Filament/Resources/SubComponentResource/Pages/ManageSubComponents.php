<?php

namespace App\Filament\Resources\SubComponentResource\Pages;

use App\Filament\Resources\SubComponentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubComponents extends ManageRecords
{
    protected static string $resource = SubComponentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
