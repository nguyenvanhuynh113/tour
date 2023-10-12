<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tours(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tour::class,'id_place');
    }

}
