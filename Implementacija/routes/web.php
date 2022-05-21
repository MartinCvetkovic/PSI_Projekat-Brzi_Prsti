<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [BaseController::class, "homePage"])->name('homePage');

Route::get('/registerPage', [GuestController::class, "registerPage"])->name('registerPage');
Route::post('/register', [GuestController::class, "register"])->name('register');
Route::post('/login', [GuestController::class, "login"])->name('login');
//Redirect na homepage ako user rucno proba da ode na /login ili /register
Route::get('/register', function() {return redirect()->route('homePage');});
Route::get('/login', function() {return redirect()->route('homePage');});


Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/texts', [UserController::class, 'showTexts'])->name('texts');
Route::get('/textsearch', [UserController::class, 'searchTexts'])->name('search_texts');

Route::get('/solo', [BaseController::class, 'soloKucanje'])->name('solo_kucanje');
Route::get('/solo/{id}', [BaseController::class, 'soloKucanje'])->name('solo_kucanje_id');
Route::post('/soloEnd', [BaseController::class, 'soloKucanjeKraj'])->name('solo_kucanje_kraj');
//Redirect na hompage ako user rucno proba da ode na /soloEnd
Route::get('/soloEnd', function() {return redirect()->route('homePage');});
Route::get('/soloResults', [BaseController::class, 'soloKucanjePrikazRezultata'])->name('solo_kucanje_rezultati');

Route::get('/daily', [UserController::class, 'dailyKucanje'])->name('daily_kucanje');
Route::post('/dailyEnd', [UserController::class, 'dailyKucanjeKraj'])->name('daily_kucanje_kraj');
//Redirect na hompage ako user rucno proba da ode na /dailyEnd
Route::get('/dailyEnd', function() {return redirect()->route('homePage');});
Route::get('/dailyResults', [UserController::class, 'dailyKucanjePrikazRezultata'])->name('daily_kucanje_rezultati');
Route::get('/dailyChange', [UserController::class, 'promeniDaily'])->name('promeni_daily');



