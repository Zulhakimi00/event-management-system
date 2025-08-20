<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialGuest extends Model
{
    protected $fillable = ['name'];


    public function eventMeals()
    {
        return $this->hasMany(EventMeal::class, 'special_guest_id');
    }
}
