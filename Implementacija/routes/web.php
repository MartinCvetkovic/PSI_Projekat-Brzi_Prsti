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

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/texts', [UserController::class, 'showTexts'])->name('texts');
Route::get('/textsearch', [UserController::class, 'searchTexts'])->name('search_texts');


Route::get('/searchusers', [UserController::class, 'searchUsers'])->name('search_users');
Route::get('/submitusersearch', [UserController::class, 'searchUsersSubmit'])->name('searchusers_submit');
Route::get('/user/{username}', [UserController::class, 'visitUser'])->name('visit_user');
Route::get('/dodaj/{username}', [UserController::class, 'dodajPrijatelja'])->name('dodaj_prijatelja');
Route::get('/blokiraj/{username}', [UserController::class, 'blokirajKorisnika'])->name('blokiraj_korisnika');
Route::get('/mod/{username}', [UserController::class, 'dodajModeratora'])->name('dodeli_mod');


//Ove tri rute treba da idu na BaseController (kad bude napravljen)
Route::get('/solo', [BaseController::class, 'soloKucanje'])->name('solo_kucanje');
Route::get('/solo/{id}', [BaseController::class, 'soloKucanje'])->name('solo_kucanje_id');
//Promeni u POST!!!
Route::post('/soloEnd', [BaseController::class, 'soloKucanjeKraj'])->name('solo_kucanje_kraj');
Route::get('/soloResults', [BaseController::class, 'soloKucanjePrikazRezultata'])->name('solo_kucanje_rezultati');


