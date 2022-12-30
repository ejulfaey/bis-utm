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

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }
}
