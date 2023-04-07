<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ConstructionCost extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'area_of_building',
        'building_type_id',
        'construction_cost',
        'mechanical_cost',
        'electrical_cost',
        'hydraulic_cost',
        'fire_service_cost',
        'lift_cost',
        'total_cost',
        'initial_cost',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn (string $eventName) => "Construction cost has been {$eventName}");
    }

    public function getInitialCostAttribute()
    {
        return round($this->total_cost * $this->area_of_building, 2);
    }

    public function type()
    {
        return $this->belongsTo(Parameter::class, 'building_type_id');
    }
}
