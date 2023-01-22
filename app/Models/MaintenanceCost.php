<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'no',
        'building_section',
        'subcomponent_id',
        'area',
        'cost',
        'no_of_unit',
        'total_cost',
    ];

    public function component()
    {
        return $this->belongsTo(Parameter::class, 'subcomponent_id');
    }

}
