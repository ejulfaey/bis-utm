<?php

namespace App\Filament\Resources\ComponentResource\Pages;

use App\Filament\Resources\ComponentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageComponents extends ManageRecords
{
    protected static string $resource = ComponentResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }
}
