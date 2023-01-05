<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    use HasFactory;

    protected $fillable = [
        'e_energy_of_cosumption',
        'e_duration_of_consumption',
        'e_tariff',
        'w_usage_of_water',
        'w_no_of_occupants',
        'w_tariff',
    ];
}
