<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InspectionPhoto extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'photo',
        'description'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn (string $eventName) => "Photo has been {$eventName}");
    }

    public function inspection()
    {
        return $this->hasMany(Inspection::class);
    }
}
