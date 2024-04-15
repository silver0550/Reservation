<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/booking', [BookingController::class, 'index'])->name('index');

Route::group([
    'prefix' => 'booking',
    'middleware' => ['auth'],
    'as' => 'booking.',
    'controller' => BookingController::class
], function () {
    Route::post('/', 'store')->name('store');
    Route::get('/create', 'create')->name('create');
    Route::get('/status', 'status')->name('status');
    Route::get('/reservation', 'reservation')->name('reservation');
    Route::get('/myAppointments', 'getMyAppointments')->name('myAppointments');
    Route::delete('/{booking}', 'destroy')->name('destroy');
    Route::put('/{booking}', 'update')->name('update');
});

Route::get('/test', function () {
    dd('test');
});

Route::get('/', function () {
    return redirect()->route('index');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
