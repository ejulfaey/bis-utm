<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const SUPERADMIN = 1;
    public const ADMIN = 2;
    public const NORMAL = 3;
}
