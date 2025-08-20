<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventItEquipment extends Model
{
    protected $table = 'event_it_equipment';

    protected $fillable = [
        'event_id',
        'it_equipment_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function itEquipment()
    {
        return $this->belongsTo(ItEquipment::class);
    }
}
