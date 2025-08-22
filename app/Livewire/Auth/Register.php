<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation, $staff_id, $department_id;

    public function register()
    {
        $this->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|confirmed',
            'staff_id'      => 'required|string|max:50',
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = User::create([
            'name'          => $this->name,
            'email'         => $this->email,
            'password'      => Hash::make($this->password),
            'staff_id'      => $this->staff_id,
            'department_id' => $this->department_id,
        ]);

        // Assign role "staff" auto
        $user->assignRole('staff');

        // Auto login selepas register
        auth()->login($user);

        // Redirect ke dashboard
        return redirect()->route('dashboard')->with('success', 'Pendaftaran berjaya!');
    }
    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth', ['title' => 'Register']);
    }
}
