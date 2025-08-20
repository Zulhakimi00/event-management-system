<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Event;
use App\Models\EventItEquipment;
use App\Models\EventMeal;
use App\Models\ItEquipment;
use App\Models\Location;
use App\Models\MealSession;
use App\Models\ServingMethod;
use App\Models\SpecialGuest;
use Livewire\Component;

class EventCreate extends Component
{
    public $name, $department_id, $function_type, $contact_no;
    public $start_date_time, $end_date_time, $location_id;
    public $it_equipment = []; // array untuk simpan IT equipment
    public $require_meals = false;
    public $meal_sessions = []; // array of meal session IDs
    public $total_pax, $total_vegetarian_meal;
    public $special_guest_id, $serving_method_id;
    public $meal_remark, $dietary_requirements;

    public $selectedMeals = [];
    public $mealTimes = [];
    public $mealRequests = [];
    public $departments;
    public $locations;
    public $mealSessions;
    public $specialGuests;
    public $servingMethods;
    public $allEquipments;

    public function mount()
    {
        $this->departments = Department::all();
        $this->locations = Location::all();
        $this->mealSessions = MealSession::all();
        $this->specialGuests = SpecialGuest::all();
        $this->servingMethods = ServingMethod::all();
        $this->allEquipments = ItEquipment::all();
    }
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'function_type' => 'required|string|max:255',
            'contact_no' => 'required|string|max:50',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            'location_id' => 'required|exists:locations,id',
            'it_equipment' => 'array',
            'total_pax' => $this->require_meals ? 'required|integer|min:1' : 'nullable|integer|min:1',
            'total_vegetarian_meal' => $this->require_meals ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'special_guest_id' => 'nullable|exists:special_guests,id',
            'serving_method_id' => $this->require_meals ? 'required|exists:serving_methods,id' : 'nullable|exists:serving_methods,id',
        ];

        if ($this->require_meals) {
            foreach ($this->meal_sessions as $session_id) {
                $rules["mealTimes.$session_id"] = 'required|date_format:H:i';
                $rules["mealRemarks.$session_id"] = 'required|string|max:500';
            }
        }

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        $event = Event::create([
            'name' => $this->name,
            'department_id' => $this->department_id,
            'function_type' => $this->function_type,
            'contact_no' => $this->contact_no,
            'start_date_time' => $this->start_date_time,
            'end_date_time' => $this->end_date_time,
            'location_id' => $this->location_id,
            'status' => 0,
        ]);

        // IT Equipment
        foreach ($this->it_equipment as $equipment_id) {
            EventItEquipment::create([
                'event_id' => $event->id,
                'it_equipment_id' => $equipment_id,
            ]);
        }

        // Meal
        if ($this->require_meals) {
            $meal = EventMeal::create([
                'event_id' => $event->id,
                'remark' => $this->meal_remark,
                'total_pax' => $this->total_pax,
                'total_vegetarian_meal' => $this->total_vegetarian_meal,
                'special_guest_id' => $this->special_guest_id  ?: null,
                'serving_method_id' => $this->serving_method_id,
            ]);
            foreach ($this->selectedMeals as $key => $session_id) {
                $meal->mealSessions()->attach($key, [
                    'time' => $this->mealTimes[$key] ?? now(),      // masa spesifik session
                    'remark' => $this->mealRequests[$key] ?? null,   // request makanan spesifik
                ]);
            }
        }

        session()->flash('message', 'Event created successfully!');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'department_id',
            'function_type',
            'contact_no',
            'start_date_time',
            'end_date_time',
            'location_id',
            'it_equipment',
            'require_meals',
            'meal_sessions',
            'total_pax',
            'total_vegetarian_meal',
            'special_guest_id',
            'serving_method_id',
            'meal_remark',
            'dietary_requirements'
        ]);
    }

    public function render()
    {
        return view('livewire.event-create')->layout('layouts.app');
    }
}
