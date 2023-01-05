<?php

namespace App\Filament\Resources\InspectionResource\Pages;

use App\Filament\Resources\InspectionResource;
use App\Models\Parameter;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateInspection extends CreateRecord
{
    protected static string $resource = InspectionResource::class;

    public $id;

    public function __construct()
    {
        $this->id = request()->query('ownerRecord');
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return "Inspection has been created";
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['classification_id'] = Parameter::firstWhere('name', $data['classification'])->id;
        $data['project_id'] = $this->id;
        $data['user_id'] = auth()->id();
        $data = Arr::except($data, ['project', 'assessor', 'college_block', 'total_floor', 'total_matrix', 'classification']);
        return $data;
    }
}
