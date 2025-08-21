<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SpecialGuest;
use App\Models\ServingMethod;
use App\Models\ItEquipment;
use App\Models\MealSession;

class EventManagement extends Component
{
    // Data
    public $specialGuests;
    public $servingMethods;
    public $itEquipments;
    public $mealSessions;

    // Modals
    public $showSpecialGuestModal = false;
    public $showServingMethodModal = false;
    public $showITEquipmentModal = false;
    public $showMealSessionModal = false;

    // Form fields
    public $guestId;
    public $specialGuestName;

    public $methodId;
    public $servingMethodName;

    public $equipmentId;
    public $itEquipmentName;

    public $mealId;
    public $mealSessionName;
    public $mealStartTime;
    public $mealEndTime;

    protected $rules = [
        'specialGuestName' => 'required|string|max:255',
        'servingMethodName' => 'required|string|max:255',
        'itEquipmentName' => 'required|string|max:255',
        'mealSessionName' => 'required|string|max:255',
        'mealStartTime' => 'required|date_format:H:i',
        'mealEndTime' => 'required|date_format:H:i|after:mealStartTime',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->specialGuests = SpecialGuest::all();
        $this->servingMethods = ServingMethod::all();
        $this->itEquipments = ItEquipment::all();
        $this->mealSessions = MealSession::all();
    }

    // ----------------------
    // Special Guest Methods
    // ----------------------
    public function openSpecialGuestModal($id = null)
    {
        $this->guestId = $id;
        if ($id) {
            $guest = SpecialGuest::find($id);
            $this->specialGuestName = $guest->name;
        } else {
            $this->specialGuestName = '';
        }
        $this->showSpecialGuestModal = true;
    }

    public function closeSpecialGuestModal()
    {
        $this->showSpecialGuestModal = false;
        $this->reset(['specialGuestName', 'guestId']);
    }

    public function saveSpecialGuest()
    {
        $this->validateOnly('specialGuestName');
        SpecialGuest::updateOrCreate(
            ['id' => $this->guestId],
            ['name' => $this->specialGuestName]
        );
        $this->closeSpecialGuestModal();
        $this->loadData();
    }

    public function deleteSpecialGuest($id)
    {
        SpecialGuest::find($id)->delete();
        $this->loadData();
    }

    // ----------------------
    // Serving Method Methods
    // ----------------------
    public function openServingMethodModal($id = null)
    {
        $this->methodId = $id;
        $this->servingMethodName = $id ? ServingMethod::find($id)->name : '';
        $this->showServingMethodModal = true;
    }

    public function closeServingMethodModal()
    {
        $this->showServingMethodModal = false;
        $this->reset(['servingMethodName', 'methodId']);
    }

    public function saveServingMethod()
    {
        $this->validateOnly('servingMethodName');
        ServingMethod::updateOrCreate(
            ['id' => $this->methodId],
            ['name' => $this->servingMethodName]
        );
        $this->closeServingMethodModal();
        $this->loadData();
    }

    public function deleteServingMethod($id)
    {
        ServingMethod::find($id)->delete();
        $this->loadData();
    }

    // ----------------------
    // IT Equipment Methods
    // ----------------------
    public function openITEquipmentModal($id = null)
    {
        $this->equipmentId = $id;
        $this->itEquipmentName = $id ? ItEquipment::find($id)->name : '';
        $this->showITEquipmentModal = true;
    }

    public function closeITEquipmentModal()
    {
        $this->showITEquipmentModal = false;
        $this->reset(['itEquipmentName', 'equipmentId']);
    }

    public function saveITEquipment()
    {
        $this->validateOnly('itEquipmentName');
        ItEquipment::updateOrCreate(
            ['id' => $this->equipmentId],
            ['name' => $this->itEquipmentName]
        );
        $this->closeITEquipmentModal();
        $this->loadData();
    }

    public function deleteITEquipment($id)
    {
        ItEquipment::find($id)->delete();
        $this->loadData();
    }

    // ----------------------
    // Meal Session Methods
    // ----------------------
    public function openMealSessionModal($id = null)
    {
        $this->mealId = $id;
        if ($id) {
            $meal = MealSession::find($id);
            $this->mealSessionName = $meal->name;
            $this->mealStartTime = $meal->start_time;
            $this->mealEndTime = $meal->end_time;
        } else {
            $this->mealSessionName = '';
            $this->mealStartTime = '';
            $this->mealEndTime = '';
        }
        $this->showMealSessionModal = true;
    }

    public function closeMealSessionModal()
    {
        $this->showMealSessionModal = false;
        $this->reset(['mealSessionName', 'mealStartTime', 'mealEndTime', 'mealId']);
    }

    public function saveMealSession()
    {
        $this->validateOnly(['mealSessionName', 'mealStartTime', 'mealEndTime']);
        MealSession::updateOrCreate(
            ['id' => $this->mealId],
            [
                'name' => $this->mealSessionName,
                'start_time' => $this->mealStartTime,
                'end_time' => $this->mealEndTime
            ]
        );
        $this->closeMealSessionModal();
        $this->loadData();
    }

    public function deleteMealSession($id)
    {
        MealSession::find($id)->delete();
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.event-management')->layout('layouts.app');
    }
}
