<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Rap2hpoutre\FastExcel\FastExcel;

trait PrintTrait
{

    public function printInspection(Collection $records)
    {
        return (new FastExcel($records))->download('test.xlsx', function ($record) {
            return [
                'Date' => $record->date,
                'Project' => $record->project->name,
            ];
        });
    }
}
