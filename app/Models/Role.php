<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelRole;

class Role extends ModelRole
{
    use HasFactory;
}
