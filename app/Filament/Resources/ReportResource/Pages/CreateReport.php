<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $filter = Arr::except($data, ['building_type', 'total_floor', 'classification']);

        $classification = Parameter::whereGroupId(Parameter::CLASSIFICATION_BUILDING)
            ->whereName($data['classification'])
            ->first();

        return array_merge($filter, [
            'classification_id' => $classification->id
        ]);
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return "Report has been created";
    }
}
