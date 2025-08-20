<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServingMethod extends Model
{
    protected $fillable = ['name'];

    public function eventMeals()
    {
        return $this->hasOne(EventMeal::class, 'serving_method_id');
    }
}
