<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionCost extends Model
{
    use HasFactory;

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
}
