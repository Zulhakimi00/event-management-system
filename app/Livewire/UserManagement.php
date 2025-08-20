<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Location;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{

    public $showVenueModal = false;
    public $showDepartmentModal = false;


    public $venueId;
    public $venueName = '';
    public $venueCapacity = '';
    public $departmentId;
    public $departmentName = '';

    public $venues = [];
    public $departments = [];
    public $users = [];

    public $showUserModal = false;
    public $userName, $userStaffId, $userDepartmentId, $userRole, $userUsername, $userPassword;

    protected $rules = [
        'userName' => 'required|string|max:255',
        'userStaffId' => 'required|string|max:50|unique:users,staff_id',
        'userDepartmentId' => 'required|exists:departments,id',
        'userRole' => 'required|string',
        'userUsername' => 'required|string|max:50|unique:users,email',
        'userPassword' => 'required|string|min:6',
    ];


    public function mount()
    {
        // Dummy Data Venues
        $this->venues = Location::all();
        // Dummy Data Departments
        $this->departments = Department::all();

        // Dummy Data Users
        $this->users = User::with('roles')->get();
    }


    //User

    public function openUserModal()
    {
        $this->reset(['userName', 'userStaffId', 'userDepartmentId', 'userRole', 'userUsername', 'userPassword']);
        $this->showUserModal = true;
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
    }

    public function saveUser()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->userName,
            'staff_id' => $this->userStaffId,
            'department_id' => $this->userDepartmentId,
            'email' => $this->userUsername,
            'password' => bcrypt($this->userPassword),
        ]);

        $user->assignRole($this->userRole);

        $this->users = User::with('department')->get(); // refresh list
        $this->closeUserModal();
    }


    // Vanue 
    public function openVenueModal()
    {
        $this->resetForm();
        $this->showVenueModal = true;
    }

    public function closeVenueModal()
    {
        $this->showVenueModal = false;
    }

    public function editVenue($id)
    {
        $venue = Location::findOrFail($id);
        $this->venueId = $venue->id;
        $this->venueName = $venue->name;
        $this->venueCapacity = $venue->capacity;

        $this->showVenueModal = true;
    }

    public function deleteVenue($id)
    {
        Location::findOrFail($id)->delete();
        $this->venues = Location::all(); // refresh list
    }
    public function saveVenue()
    {
        $this->validate([
            'venueName' => 'required|string|max:255',
            'venueCapacity' => 'required|integer|min:1',
        ]);

        if ($this->venueId) {
            // Update
            $venue = Location::findOrFail($this->venueId);
            $venue->update([
                'name' => $this->venueName,
                'capacity' => $this->venueCapacity,
            ]);
        } else {
            // Create baru
            Location::create([
                'name' => $this->venueName,
                'capacity' => $this->venueCapacity,
            ]);
        }
        $this->venues = Location::all();
        $this->closeVenueModal();
    }



    public function openDepartmentModal($id = null)
    {
        $this->resetDepartmentForm();

        if ($id) {
            // mode edit
            $dept = Department::findOrFail($id);
            $this->departmentId = $dept->id;
            $this->departmentName = $dept->name;
        }

        $this->showDepartmentModal = true;
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Refresh user list
        $this->users = User::with('department')->get();

        session()->flash('message', 'User deleted successfully.');
    }
    public function saveDepartment()
    {
        $this->validate([
            'departmentName' => 'required|string',
        ]);

        if ($this->departmentId) {
            // update
            $dept = Department::findOrFail($this->departmentId);
            $dept->update([
                'name' => $this->departmentName,
            ]);
        } else {
            // create baru
            Department::create([
                'name' => $this->departmentName,
            ]);
        }

        // refresh list
        $this->departments = Department::all();

        $this->closeDepartmentModal();
    }

    public function deleteDepartment($id)
    {

        Department::findOrFail($id)->delete();
        $this->departments = Department::all();
    }

    public function closeDepartmentModal()
    {
        $this->showDepartmentModal = false;
        $this->resetDepartmentForm();
    }

    private function resetDepartmentForm()
    {
        $this->departmentId = null;
        $this->departmentName = '';
    }

    public function render()
    {
        return view('livewire.user-management')->layout('layouts.app');
    }
}
