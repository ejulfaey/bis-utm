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

    protected $appends = [
        'total_energy_usage',
        'daily_electrical_cost',
        'yearly_electrical_cost',
        'total_water_usage',
        'daily_water_cost',
        'yearly_water_cost',
    ];

    public function getTotalEnergyUsageAttribute()
    {
        return round(floatval($this->e_energy_of_consumption) * floatval($this->e_duration_of_consumption), 2);
    }

    public function getDailyElectricalCostAttribute()
    {
        return round($this->total_energy_usage * floatval($this->e_tariff), 2);
    }

    public function getYearlyElectricalCostAttribute()
    {
        return round($this->daily_electrical_cost * 365, 2);
    }

    public function getTotalWaterUsageAttribute()
    {
        return round(floatval($this->w_usage_of_water) * floatval($this->w_no_of_occupants), 2);
    }

    public function getDailyWaterCostAttribute()
    {
        return round($this->total_water_usage * floatval($this->w_tariff), 2);
    }

    public function getYearlyWaterCostAttribute()
    {
        return round($this->daily_water_cost * 365, 2);
    }
}
