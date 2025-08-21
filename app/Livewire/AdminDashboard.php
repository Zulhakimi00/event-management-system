<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use App\Models\Location;
use App\Models\Department;
use Livewire\Attributes\On;

class AdminDashboard extends Component
{
    public $totalEvents = 0;
    public $activeUsers = 0;
    public $pendingOrders = 0;
    public $mealOrders;

    public $venues = [];
    public $departments = [];
    public $events = [];
    public $showModal = false;
    public $event;
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
        $this->loadData();
    }

    public function loadData()
    {
        $this->totalEvents = Event::count();
        $this->activeUsers = User::count();
        $this->pendingOrders = Event::where('status', 0)->count();

        $this->venues = Location::select('id', 'name')->get();
        $this->departments = Department::select('id', 'name')->get();

        $this->events = Event::with(['department', 'location'])
            ->where('status', 1)
            ->orderBy('date', 'asc')
            ->take(10)
            ->get();
    }
    public function confirmCancel($eventId)
    {
        // Trigger browser event
        $this->dispatch('show-cancel-popup', id: $eventId);
    }

    #[On('cancelEventConfirmed')]
    public function cancelEventConfirmed($eventId)
    {
        $event = Event::find($eventId);

        if ($event) {
            $event->status = 0; // cancel
            $event->save();
        }
        $this->loadData();
        $this->dispatch('show-toast', message: 'Event berjaya dibatalkan.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin-dashboard')->layout('layouts.app');
    }
}
