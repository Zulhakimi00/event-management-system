<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/dashboard'); // tukar ikut route
        }

        $this->addError('email', 'Email atau password salah.');
    }
    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth', ['title' => 'Login']);
    }
}
