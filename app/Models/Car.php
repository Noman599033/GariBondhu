<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = [];

    public function category() { return $this->belongsTo(CarCategory::class); }
    public function brand() { return $this->belongsTo(CarBrand::class); }
    public function images() { return $this->hasMany(CarImage::class); }
    // Prices are now managed globally via PricingRule
    public function blockouts() { return $this->hasMany(CarBlockout::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
}
