<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class Calendar extends Component
{
    public $currentMonth;
    public $days = [];

    public function mount()
    {
        $this->currentMonth = Carbon::now()->startOfMonth();
        $this->generateDays();
    }

    public function previousMonth()
    {
        $this->currentMonth = $this->currentMonth->copy()->subMonth();
        $this->generateDays();
    }

    public function nextMonth()
    {
        $this->currentMonth = $this->currentMonth->copy()->addMonth();
        $this->generateDays();
    }

    public function goToToday()
    {
        $this->currentMonth = Carbon::now()->startOfMonth();
        $this->generateDays();
    }

    private function generateDays()
    {
        $startOfMonth = $this->currentMonth->copy()->startOfMonth();
        $endOfMonth   = $this->currentMonth->copy()->endOfMonth();

        $daysInMonth = [];
        $startDayOfWeek = $startOfMonth->dayOfWeek; // 0=Sunday
        $totalDays = $endOfMonth->day;

        // padding kosong sebelum hari 1
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $daysInMonth[] = null;
        }

        // semua hari bulan
        for ($d = 1; $d <= $totalDays; $d++) {
            $daysInMonth[] = Carbon::createFromDate(
                $this->currentMonth->year,
                $this->currentMonth->month,
                $d
            );
        }

        $this->days = $daysInMonth;
    }

    public function render()
    {
        return view('livewire.calendar')->layout('layouts.app');
    }
}
