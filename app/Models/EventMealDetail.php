<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMealDetail extends Model
{
    protected $fillable = [
        'event_meal_id',
        'meal_session_id',
        'time',
        'remark',
    ];

    public function eventMeal()
    {
        return $this->belongsTo(EventMeal::class);
    }

    public function mealSession()
    {
        return $this->belongsTo(MealSession::class);
    }
}
