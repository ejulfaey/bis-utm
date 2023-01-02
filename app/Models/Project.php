<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'user_id',
        'plan_attachment',
        'building_type_id',
        'college_block',
        'total_floor',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn (string $eventName) => "Project has been {$eventName}");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function building_type()
    {
        return $this->belongsTo(Parameter::class, 'building_type_id');
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    public function inspection_architectural()
    {
        return $this->inspections()->where('component_id', Parameter::COMP_ARCHITECTURAL);
    }

    public function inspection_structural()
    {
        return $this->inspections()->where('component_id', Parameter::COMP_STRUCTURAL);
    }

    public function inspection_building()
    {
        return $this->inspections()->where('component_id', Parameter::COMP_BUILDING_SERVICE);
    }

}
