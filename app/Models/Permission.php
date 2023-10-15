<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelPermission;

class Permission extends ModelPermission
{
    use HasFactory;
}
