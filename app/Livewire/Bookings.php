<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class Bookings extends Component
{
    public $events = [];
    public $showModal = false;
    public $event;
    public $mealOrders;

    // Listener untuk trigger buka modal
    protected $listeners = ['showEventMealModal'];

    public function showEventMealModal($eventId)
    {
        $this->event = Event::with([
            'department',
            'eventType',
            'location',
            'meals.details.mealSession'
        ])->findOrFail($eventId);

        $this->mealOrders = $this->event->meals;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->event = null;
        $this->mealOrders = null;
    }


    public function mount()
    {
        $twoDaysFromNow = now()->addDays(2);

        $this->events = Event::with(['department', 'location', 'itEquipments', 'meals'])->get();
    }


    public function render()
    {
        return view('livewire.bookings')->layout('layouts.app');
    }
}
