<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function ()
{
    return view('index');
})->name('index');

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotel/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/add_hotel', [HotelController::class, 'addHotel']);
Route::post('/save_hotel', [HotelController::class, 'saveHotel'])->name('save.hotel');
Route::get('/edit_hotel_facilities/{hotel_id}', [HotelController::class, 'editHotelFacilities'])->name('edit_hotel_facilities');
Route::post('/save_hotel_facilities', [HotelController::class, 'saveHotelFacilities'])->name('save.hotel.facilities');
Route::get('/add_room/{hotel_id}', [HotelController::class, 'addRoom']);
Route::post('/save_room', [HotelController::class, 'saveRoom'])->name('save.room');
Route::get('/edit_room_facilities/{room_id}', [HotelController::class, 'editRoomFacilities']);
Route::post('/save_room_facilities', [HotelController::class, 'saveRoomFacilities'])->name('save.room.facilities');
Route::get('/delete_hotel/{id}', [HotelController::class, 'delete']);

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registration'])->name('registration');
Route::get('verify_email/{email}', [UserController::class, 'verifyEmail'])->name('verify.email');
Route::post('/verify_email', [UserController::class, 'verification'])->name('verification.send');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'signIn'])->name('sign_in');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [UserController::class, 'forgotPassword'])->name('password.request');
Route::post('/reset', [UserController::class, 'resetPassword'])->name('password.email');
Route::get('/set-new-password', [UserController::class, 'setNewPassword']);
Route::post('/update-password/', [UserController::class, 'updatePassword'])->name('password.reset');

Route::middleware('auth:web')->group(function()
{
    Route::get('/show_bookings/{user_id}', [BookingController::class, 'showBookings'])->name('bookings.index');
    Route::get('/show_booking/{booking_id}', [BookingController::class, 'showBooking'])->name('booking.show');
    Route::post('/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/delete_booking/{id}', [BookingController::class, 'delete']);
});


