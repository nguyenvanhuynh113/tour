<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'coupon_tours', 'id_coupon', 'id_tour');
    }
}
