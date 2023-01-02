<?php

namespace App\Models;

use Database\Seeders\ParameterSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    public const WEATHER = 1;
    public const LOCATION = 2;
    public const COMPONENT = 3;
    public const SUBCOMPONENT = 4;
    public const DEFECT = 5;
    public const CLASSIFICATION = 6;
    public const BUILDING_TYPE = 7;
    public const SCORE_CONDITION = 8;
    public const SCORE_MAINTENANCE = 9;
    public const CLASSIFICATION_BUILDING = 10;

    public function parent()
    {
        return $this->belongsTo(ParameterSeeder::class, 'parent_id');
    }
}
