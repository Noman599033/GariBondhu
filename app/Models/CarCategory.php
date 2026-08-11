<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarCategory extends Model
{
    protected $guarded = [];

    public function cars()
    {
        return $this->hasMany(Car::class, 'category_id');
    }
}
