<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventMeal extends Model
{
    protected $fillable = [
        'event_id',
        'remark',
        'total_pax',
        'total_vegetarian_meal',
        'special_guest_id',
        'serving_method_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function specialGuest()
    {
        return $this->belongsTo(SpecialGuest::class);
    }

    public function servingMethod()
    {
        return $this->belongsTo(ServingMethod::class);
    }

    public function details()
    {
        return $this->hasMany(EventMealDetail::class);
    }
    public function mealSessions(): BelongsToMany
    {
        return $this->belongsToMany(MealSession::class, 'event_meal_details')
            ->withPivot('time', 'remark')
            ->withTimestamps();
    }
}
