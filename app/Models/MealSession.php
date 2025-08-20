<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealSession extends Model
{
    protected $fillable = ['name', 'start_time', 'end_time'];

    public function mealDetails()
    {
        return $this->hasMany(EventMealDetail::class);
    }
}
