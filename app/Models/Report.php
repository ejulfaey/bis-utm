<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
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

    public function getColorAttribute()
    {
        if ($this->bca_score > 80) return 'bg-green-500 text-white';
        else if ($this->bca_score > 70) return 'bg-blue-500 text-white';
        else return 'bg-yellow-500';
    }
}
