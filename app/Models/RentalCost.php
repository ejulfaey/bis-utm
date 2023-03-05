<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_room',
        'no_of_room',
    ];

    public function getTotalRentalAttribute()
    {
        return $this->cost_room * $this->no_of_room * 365;
    }
}
