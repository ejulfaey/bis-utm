<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditReport extends EditRecord
{
    protected static string $resource = ReportResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $filter = Arr::except($data, ['building_type', 'total_floor', 'classification']);

        $classification = Parameter::whereGroupId(Parameter::CLASSIFICATION_BUILDING)
            ->whereName($data['classification'])
            ->first();

        return array_merge($filter, [
            'classification_id' => $classification->id
        ]);
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return "Report has been updated";
    }
}
