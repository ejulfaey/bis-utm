<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    public const LOCATION = 1;
    public const COMPONENT = 2;
    public const SUBCOMPONENT = 3;
    public const DEFECT = 4;
    public const SCORE_CONDITION = 5;
    public const SCORE_MAINTENANCE = 6;
}
