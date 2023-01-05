<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'location_id',
        'subcomponent_id',
        'area',
        'cost',
        'no_of_unit',
        'total_cost',
    ];

}
