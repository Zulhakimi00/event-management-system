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
    public $showEditModal = false;
    public $editEventId;
    public $editName;
    public $editContact;
    public $editDate;
    public $editStartTime;
    public $editEndTime;
    public $editLocationId;
    public $locations;

    public $timeSlots = [];
    public $showCancelModal = false;
    public $cancelEventId;
    public $mealOrder;


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



    public function openEditModal($eventId)
    {
        $event = Event::find($eventId);
        if (!$event) return;

        $this->editEventId = $event->id;
        $this->editName = $event->name;
        $this->editContact = $event->contact_no;
        $this->editDate = $event->date;
        $this->editStartTime = \Carbon\Carbon::parse($event->start_time)->format('H:i');
        $this->editEndTime = \Carbon\Carbon::parse($event->end_time)->format('H:i');
        $this->editLocationId = $event->location_id;

        $this->showEditModal = true;
    }

    public function saveEdit()
    {
        $event = Event::find($this->editEventId);
        if (!$event) return;

        $event->update([
            'name' => $this->editName,
            'contact_no' => $this->editContact,
            'date' => $this->editDate,
            'start_time' => $this->editStartTime,
            'end_time' => $this->editEndTime,
            'location_id' => $this->editLocationId,
        ]);
        $this->loadFetchData();

        $this->showEditModal = false;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
    }

    public function mount()
    {
        $this->loadFetchData();
        $this->locations = \App\Models\Location::pluck('name', 'id');
        $this->generateTimeSlots();
    }

    public function loadFetchData()
    {
        $this->events = Event::with(['department', 'location', 'itEquipments', 'meals'])->orderBy('date', 'asc')
            ->where('user_id', auth()->id())
            ->get();
    }


    private function generateTimeSlots()
    {
        $start = strtotime('08:00');
        $end   = strtotime('22:00');
        $this->timeSlots = [];

        while ($start <= $end) {
            $this->timeSlots[] = date('H:i', $start);
            $start = strtotime('+30 minutes', $start);
        }
    }

    public function confirmCancel($eventId)
    {
        $event = Event::with('meals')->find($eventId);
        if (!$event) return;

        $this->cancelEventId = $event->id;
        $this->mealOrder = $event->meals; // null jika tiada meal
        $this->showCancelModal = true;
    }

    public function cancelBooking()
    {
        $event = Event::find($this->cancelEventId);
        if (!$event) return;

        if ($event->meals && $event->meals->status != 2) {
            // Kalau ada meal, jangan cancel terus, alert user
            $this->dispatch('meal-cancel-warning', [
                'mealId' => $event->meals->id,
                'message' => 'This booking includes a meal order. Please contact dietary first.'
            ]);
            return;
        }

        // Cancel event
        $event->update(['status' => 0]); // 0 = Cancelled
        $this->loadFetchData();
        $this->showCancelModal = false;

        $this->dispatch('booking-cancelled', ['message' => 'Booking cancelled successfully.']);
    }

    public function render()
    {
        return view('livewire.bookings')->layout('layouts.app');
    }
}
