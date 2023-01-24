<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'area_of_building',
        'structural_score',
        'structural_percent',
        'architectural_score',
        'architectural_percent',
        'building_score',
        'building_percent',
        'bca_score',
        'classification_id',
        'initial_cost',
        'maintenance_cost',
        'time_period',
        'discount_rate',
        'npv_maintenance',
        'energy_usage',
        'water_usage',
        'rental_cost',
        'lcca',
        'summary',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function classification()
    {
        return $this->belongsTo(Parameter::class, 'classification_id');
    }

}
