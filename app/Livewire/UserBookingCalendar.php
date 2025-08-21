<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UserBookingCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $events = [];
    public $showModal = false;
    public $event; // selected event
    public $mealOrders; // optional meal orders
    public function mount()
    {
        $now = Carbon::now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;

        $this->loadEvents();
    }

    public function loadEvents()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate   = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();

        $this->events = Event::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($event) {
                return Carbon::parse($event->date)->day;
            })
            ->map(function ($dayEvents) {
                return $dayEvents->map(function ($event) {
                    $isMyEvent = false;

                    // Kalau role 'user', semua event milik dia
                    if (auth()->user()->role == 'staff') {
                        $isMyEvent = true;
                    } else {
                        $isMyEvent = auth()->id() == $event->user_id;
                    }

                    return [
                        'id' => $event->id,
                        'name' => $event->name,
                        'is_my_event' => $isMyEvent
                    ];
                });
            })
            ->toArray();
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadEvents();
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadEvents();
    }

    public function goToToday()
    {
        $now = Carbon::now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;
        $this->loadEvents();
    }

    // Open modal for event
    public function showEvent($eventId)
    {

        $this->event = Event::with(['department', 'location', 'itEquipments', 'eventType', 'meals'])
            ->find($eventId); // object, bukan array

        if ($this->event) {
            $this->mealOrders = $this->event->meals;
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->event = null;
        $this->mealOrders = null;
    }

    public function render()
    {
        return view('livewire.user-booking-calendar')->layout('layouts.app');
    }
}
