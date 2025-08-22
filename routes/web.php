<?php

use App\Http\Controllers\BookingController;
use App\Livewire\AdminDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Bookings;
use App\Livewire\Dashboard;
use App\Livewire\EventCreate;
use App\Livewire\EventManagement;
use App\Livewire\MealOrdersManagement;
use App\Livewire\UserBookingCalendar;
use App\Livewire\UserManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/calendar', UserBookingCalendar::class)->name('calendar');
Route::get('/booking', Bookings::class)->name('booking');
Route::get('/user-management', UserManagement::class)->name('user-management');
Route::get('/event-management', EventManagement::class)->name('event-management');
Route::get('/create-booking', EventCreate::class)->name('create-booking');
Route::get('/meal-orders-management', MealOrdersManagement::class)->name('meal-orders-management');
Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
Route::get('/booking/{id}/pdf', [BookingController::class, 'generatePdf'])->name('booking.pdf');



Route::post('logout', function (Request $request) {
    Auth::logout(); // log keluar user
    return redirect('/login'); // redirect ke login page
})->name('logout');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// require __DIR__ . '/auth.php';
