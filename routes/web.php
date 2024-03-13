<?php

use App\Http\Controllers\PaymentGatewayController;
use App\Livewire\About;
use App\Livewire\Home;
use App\Livewire\Users;
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
Route::view('/', 'welcome');
Route::post('charge',[PaymentGatewayController::class,'charge']);
Route::get('charge-process',[PaymentGatewayController::class,'chargeprocess'])->name('charge-process');




// navigate
Route::get('home',Home::class);
Route::get('about',About::class);
Route::get('users',Users::class);
