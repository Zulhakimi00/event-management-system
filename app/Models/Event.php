<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'department_id',
        'start_date_time',
        'end_date_time',
        'location_id',
        'status',
        'contact_no',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];
    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function itEquipments()
    {
        return $this->belongsToMany(ItEquipment::class, 'event_it_equipment');
    }

    public function meals()
    {
        return $this->hasOne(EventMeal::class, 'event_id');
    }
}
