<?php

namespace App\Traits;

use App\Models\Inspection;
use Illuminate\Database\Eloquent\Collection;
use Rap2hpoutre\FastExcel\FastExcel;

trait PrintTrait
{

    public function printInspection(Collection $records)
    {
        return response()->streamDownload(function () use ($records) {
            return (new FastExcel($records))->export('php://output', function ($record) {
                return [
                    'Date' => $record->date->format('d/m/Y'),
                    'Project' => $record->project->name,
                    'Assessor' => $record->user->name,
                    'Weather' => $record->weather->name,
                    'Floor No.' => $record->floor_no,
                    'Unit No.' => $record->unit_no,
                    'Location' => $record->location->name,
                    'Component' => $record->component->name,
                    'Sub-Component' => $record->subcomponent->name,
                    'Defect' => $record->defect->name,
                    'Condition Score Value' => $record->condition_score->value,
                    'Condition Score Label' => $record->condition_score->name,
                    'Maintenance Score Value' => $record->maintenance_score->value,
                    'Maintenance Score Label' => $record->maintenance_score->name,
                    'Total Matrix' => $record->total_matrix,
                    'Classification' => $record->classification->name,
                    'Remark' => $record->remark,
                    'Created Date' => $record->created_at->format('d/m/Y'),
                ];
            });
        }, sprintf('INSPECTIONS-' . now()->format('ymdHIs') . '.xlsx', date('Y-m-d')));
    }

    public function printProject(Collection $records)
    {
        return response()->streamDownload(function () use ($records) {
            return (new FastExcel($records))->export('php://output', function ($record) {
                return [
                    'Project' => $record->name,
                    'Project Leader' => $record->user->name,
                    'Building Type' => $record->building_type->name,
                    'College/Block.' => $record->college_block,
                    'Total Floor.' => $record->total_floor,
                    'Area of Building' => $record->area_of_building,
                    'Total Inspections' => $record->inspections->count(),
                    'Created Date' => $record->created_at->format('d/m/Y'),
                ];
            });
        }, sprintf('PROJECTS-' . now()->format('ymdHIs') . '.xlsx', date('Y-m-d')));
    }

    public function printReport(Collection $records)
    {
        return response()->streamDownload(function () use ($records) {
            return (new FastExcel($records))->export('php://output', function ($record) {
                return [
                    'Date' => $record->created_at->format('d/m/Y'),
                    'Project' => $record->project->name,
                    'Architectural Score' => $record->architectural_score,
                    'Architectural Percent' => $record->architectural_percent,
                    'Structural Score' => $record->structural_score,
                    'Structural Percent' => $record->structural_percent,
                    'Building Service Score' => $record->building_score,
                    'Building Service Percent' => $record->building_percent,
                    'BCA Score' => $record->bca_score,
                    'Building Classification' => $record->classification->name,
                    'Cost of Maintenance' => $record->maintenance_cost,
                    'Time Period' => $record->time_period,
                    'NPV For Maintenance' => $record->npv_maintenance,
                    'Initial Cost of Construction' => $record->initial_cost,
                    'Energy Usage Cost' => $record->energy_usage,
                    'Water Usage Cost' => $record->water_usage,
                    'Rental Value' => $record->rental_cost,
                    'Life Cycle Cost Analysis' => $record->lcca,
                    'Summary' => $record->summary,
                ];
            });
        }, sprintf('REPORTS-' . now()->format('ymdHIs') . '.xlsx', date('Y-m-d')));
    }
}
