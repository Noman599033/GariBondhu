<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CarCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    /**
     * Finds the best matching pricing rule for a given car.
     * It prioritizes rules with the most matching specific criteria.
     */
    public static function findBestMatch(Car $car)
    {
        return self::where('status', 'active')
            ->where(function ($query) use ($car) {
                $query->whereNull('category_id')->orWhere('category_id', $car->category_id);
            })
            ->where(function ($query) use ($car) {
                $query->whereNull('brand_id')->orWhere('brand_id', $car->brand_id);
            })
            ->where(function ($query) use ($car) {
                $query->whereNull('year')->orWhere('year', $car->year);
            })
            ->where(function ($query) use ($car) {
                $query->whereNull('seats')->orWhere('seats', $car->seats);
            })
            // Sort by the number of specific criteria matched (most specific first)
            ->orderByRaw('(IF(category_id IS NOT NULL, 1, 0) + IF(brand_id IS NOT NULL, 1, 0) + IF(year IS NOT NULL, 1, 0) + IF(seats IS NOT NULL, 1, 0)) DESC')
            ->first();
    }
}
