<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItEquipment extends Model
{
    protected $table = 'it_equipments';

    protected $fillable = [
        'name',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_it_equipment');
    }
}
