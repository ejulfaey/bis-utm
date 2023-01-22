<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    use HasFactory;

    protected $fillable = [
        'e_energy_of_consumption',
        'e_duration_of_consumption',
        'e_tariff',
        'w_usage_of_water',
        'w_no_of_occupants',
        'w_tariff',
    ];

    public function getTotalEnergyUsageAttribute()
    {
        return $this->e_energy_of_consumption * $this->e_duration_of_consumption;
    }

    public function getDailyElectricalCostAttribute()
    {
        return $this->total_energy_usage * $this->e_tariff;
    }

    public function getYearlyElectricalCostAttribute()
    {
        return $this->daily_electrical_cost * 365;
    }

    public function getTotalWaterUsageAttribute()
    {
        return $this->w_usage_of_water * $this->w_no_of_occupants;
    }

    public function getDailyWaterCostAttribute()
    {
        return $this->total_water_usage * $this->w_tariff;
    }

    public function getYearlyWaterCostAttribute()
    {
        return $this->daily_water_cost * 365;
    }

}
