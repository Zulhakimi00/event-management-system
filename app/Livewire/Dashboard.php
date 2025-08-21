<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class Dashboard extends Component
{
    public $userName;
    public $totalEvents = 0;
    public $pendingOrders = 0;
    public $upcomingEvents = 0;

    public function mount()
    {
        $user = auth()->user();

        // Nama user
        $this->userName = $user->name;

        // Total event user
        $this->totalEvents = Event::where('user_id', $user->id)->count();

        // Total event yang masih pending
        $this->pendingOrders = Event::where('user_id', $user->id)
            ->where('status', 0) // 0 = Pending/Cancel ikut status yang kau guna
            ->count();

        // Total event akan datang (tarikh lebih besar atau sama dengan hari ni)
        $this->upcomingEvents = Event::where('user_id', $user->id)
            ->whereDate('date', '>=', now()->toDateString())
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
