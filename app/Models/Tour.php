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

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Type::class, 'id_type');
    }

    public function departure_dates()
    {
        return $this->hasMany(DepartureDate::class, 'id_tour');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_tours', 'id_tour', 'id_coupon');
    }
}
