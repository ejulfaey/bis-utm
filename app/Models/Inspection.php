<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Inspection extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'project_id',
        'user_id',
        'date',
        'weather_id',
        'floor_no',
        'unit_no',
        'grid_no',
        'location_id',
        'component_id',
        'sub_component_id',
        'defect_id',
        'condition_score_id',
        'maintenance_score_id',
        'remark',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn (string $eventName) => "Inspection has been {$eventName}");
    }

    public function getTotalMatrixAttribute()
    {
        return $this->condition_score->value * $this->maintenance_score->value;
    }

    public function getClassificationAttribute()
    {
        return Parameter::whereGroupId(Parameter::CLASSIFICATION)
            ->whereRaw('? between `from` and `to`', $this->total_matrix)
            ->first();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weather()
    {
        return $this->belongsTo(Parameter::class, 'weather_id');
    }

    public function location()
    {
        return $this->belongsTo(Parameter::class, 'location_id');
    }

    public function component()
    {
        return $this->belongsTo(Parameter::class, 'component_id');
    }

    public function subcomponent()
    {
        return $this->belongsTo(Parameter::class, 'sub_component_id');
    }

    public function defect_id()
    {
        return $this->belongsTo(Parameter::class, 'defect_id');
    }

    public function condition_score()
    {
        return $this->belongsTo(Parameter::class, 'condition_score_id');
    }

    public function maintenance_score()
    {
        return $this->belongsTo(Parameter::class, 'maintenance_score_id');
    }

    public function photos()
    {
        return $this->hasMany(InspectionPhoto::class);
    }
}
