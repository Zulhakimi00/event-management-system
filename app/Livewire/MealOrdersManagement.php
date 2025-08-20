<?php

namespace App\Livewire;

use App\Models\EventMeal;
use App\Models\EventMealDetail;
use App\Models\MealSession;
use App\Models\ServingMethod;
use App\Models\SpecialGuest;
use Carbon\Carbon;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class MealOrdersManagement extends Component
{
    public $filter = 'all';
    public $mealOrders;
    public $isEditModalOpen = false;
    public $mealSessions = [];
    public $specialGuests = [];
    public $servingMethods = [];


    public $showModal = false;
    public $selectedOrder;
    protected $listeners = ['showOrder'];

    public function showOrder($id)
    {
        $this->selectedOrder = EventMeal::with(['event', 'mealSessions'])->findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedOrder = null;
    }


    public function exportPdf($id)
    {
        $order = EventMeal::with(['event', 'mealSession', 'mealType', 'specialGuest', 'servingMethod'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.meal-order', compact('order'));
        return response()->streamDownload(fn() => print($pdf->output()), 'meal-order-' . $order->id . '.pdf');
    }


    public $editForm = [
        'id' => null,
        'total_pax' => '',
        'total_vegetarian_meal' => '',
        'remark' => '',
        'modification_reason' => '',
        'serving_method_id' => '',
        'special_guest_id' => '',
        'details' => [], // tambah untuk session meal
    ];

    public function openEditModal($id)
    {
        $order = EventMeal::with('details')->findOrFail($id);

        // assign main order
        $this->editForm = [
            'id' => $order->id,
            'total_pax' => $order->total_pax,
            'total_vegetarian_meal' => $order->total_vegetarian_meal,
            'remark' => $order->remark,
            'modification_reason' => '',
            'serving_method_id' => $order->serving_method_id,
            'special_guest_id' => $order->special_guest_id,
            'details' => [],
        ];

        // loop details
        foreach ($order->details as $detail) {

            $this->editForm['details'][$detail->id] = [
                'meal_session_id' => $detail->meal_session_id,
                'time' => $detail->time,
                'remark' => $detail->remark,
            ];
        }

        $this->isEditModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
    }

    public function updateOrder()
    {
        $order = EventMeal::findOrFail($this->editForm['id']);

        // update main order
        $order->update([
            'total_pax' => $this->editForm['total_pax'],
            'total_vegetarian_meal' => $this->editForm['total_vegetarian_meal'],
            'remark' => $this->editForm['remark'],
        ]);

        // update details
        foreach ($this->editForm['details'] as $detailId => $data) {
            $detail = $order->details()->where('id', $detailId)->first();
            if ($detail) {
                $detail->update([
                    'meal_session_id' => $data['meal_session_id'],
                    'time' => $data['time'],
                    'remark' => $data['remark'],
                ]);
            }
        }

        session()->flash('success', 'Meal order updated successfully!');
        $this->isEditModalOpen = false;
    }
    public function mount()
    {
        $this->loadMealOrders();
        $this->mealSessions = MealSession::get();
        $this->specialGuests = SpecialGuest::all();
        $this->servingMethods = ServingMethod::all();
    }

    public function updatedFilter()
    {
        $this->loadMealOrders();
    }

    public function loadMealOrders()
    {

        $query = EventMeal::with(['event', 'details.mealSession', 'specialGuest', 'servingMethod']);

        if ($this->filter == 'reminders') {
            $query->whereHas('event', function ($q) {
                $q->where('start_date_time', '<=', Carbon::now()->addDays(2));
            });
        } elseif ($this->filter == '3days') {
            $query->whereHas('event', function ($q) {
                $q->whereBetween('start_date_time', [Carbon::now(), Carbon::now()->addDays(3)]);
            });
        } elseif ($this->filter == 'week') {
            $query->whereHas('event', function ($q) {
                $q->whereBetween('start_date_time', [Carbon::now(), Carbon::now()->endOfWeek()]);
            });
        } elseif ($this->filter == 'month') {
            $query->whereHas('event', function ($q) {
                $q->whereMonth('start_date_time', Carbon::now()->month);
            });
        }

        $this->mealOrders = $query->get();
    }


    public function approve($id)
    {
        EventMeal::where('id', $id)->update(['status' => 1]);


        $this->loadMealOrders();
        session()->flash('success', 'Order approved!');
    }

    public function cancel($id)
    {
        EventMeal::where('id', $id)->update(['status' => 0]);

        $this->loadMealOrders();
        session()->flash('success', 'Order cancelled!');
    }
    // export pdf
    public function exportMealPdf()
    {
        $meal = $this->selectedMeal;
        $pdf = Pdf::loadView('pdf.meal-session', compact('meal'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'meal-session-' . $meal->id . '.pdf');
    }
    public function render()
    {
        // Count quick stats
        $remindersCount = EventMealDetail::whereHas('eventMeal.event', function ($q) {
            $q->where('start_date_time', '<=', Carbon::now()->addDays(2));
        })->count();

        $pendingCount = $this->mealOrders->where('status', 0)->count();
        $approvedCount = $this->mealOrders->where('status', 1)->count();
        $totalPaxCount = EventMealDetail::join('event_meals', 'event_meal_details.event_meal_id', '=', 'event_meals.id')
            ->sum('event_meals.total_pax');

        return view('livewire.meal-orders-management', compact(
            'remindersCount',
            'pendingCount',
            'approvedCount',
            'totalPaxCount'
        ))->layout('layouts.app');
    }
}
