<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $userName;
    public $totalEvents = 0;
    public $pendingOrders = 0;
    public $upcomingEvents = 0;

    public function mount()
    {
        $this->userName = 'User';
        $this->totalEvents = 12;
        $this->pendingOrders = 3;
        $this->upcomingEvents = 5;
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
