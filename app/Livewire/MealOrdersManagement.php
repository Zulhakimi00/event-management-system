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

        $now = Carbon::now();

        $filters = [
            'reminders' => function ($q) use ($now) {
                $q->whereDate('date', '<=', $now->copy()->addDays(2)->toDateString());
            },

            '3days' => function ($q) use ($now) {
                $q->whereBetween('date', [
                    $now->toDateString(),
                    $now->copy()->addDays(3)->toDateString(),
                ]);
            },

            'week' => function ($q) use ($now) {
                $q->whereBetween('date', [
                    $now->toDateString(),
                    $now->copy()->endOfWeek()->toDateString(),
                ]);
            },

            'month' => function ($q) use ($now) {
                $q->whereMonth('date', $now->month)
                    ->whereYear('date', $now->year);
            },
        ];

        if (isset($filters[$this->filter])) {
            $query->whereHas('event', $filters[$this->filter]);
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
        EventMeal::where('id', $id)->update(['status' => 2]);

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
            $q->whereDate('date', '<=', Carbon::now()->addDays(2));
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
