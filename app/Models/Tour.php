<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function place(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Place::class, 'id_place');
    }

    public function departure_dates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DepartureDate::class, 'id_tour');
    }
}
