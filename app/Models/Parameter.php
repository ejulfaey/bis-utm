<?php

namespace App\Models;

use Database\Seeders\ParameterSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Parameter extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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
    public const ROOM_TYPE = 11;

    public const COMP_STRUCTURAL = 54;
    public const COMP_ARCHITECTURAL = 55;
    public const COMP_BUILDING_SERVICE = 56;

    protected $fillable = [
        'name',
        'group_id',
        'is_active',
        'parent_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn (string $eventName) => "Parameter has been {$eventName}");
    }

    public function parent()
    {
        return $this->belongsTo(Parameter::class, 'parent_id');
    }

    public function subcomponent()
    {
        return $this->hasMany(Parameter::class, 'parent_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }
}
