<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\TextsController;
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
Route::get('/recommendTexts', [UserController::class, 'recommendTexts'])->name('recommend_texts');


Route::get('/searchusers', [UserController::class, 'searchUsers'])->name('search_users');
Route::get('/submitusersearch', [UserController::class, 'searchUsersSubmit'])->name('searchusers_submit');
Route::get('/user/{username}', [UserController::class, 'visitUser'])->name('visit_user');
Route::get('/dodaj/{username}', [UserController::class, 'dodajPrijatelja'])->name('dodaj_prijatelja');
Route::get('/blokiraj/{username}', [UserController::class, 'blokirajKorisnika'])->name('blokiraj_korisnika');
Route::get('/mod/{username}', [UserController::class, 'dodajModeratora'])->name('dodeli_mod');


Route::get('/solo', [BaseController::class, 'soloKucanje'])->name('solo_kucanje');
Route::get('/solo/{id}', [BaseController::class, 'soloKucanje'])->name('solo_kucanje_id');
Route::post('/soloEnd', [BaseController::class, 'soloKucanjeKraj'])->name('solo_kucanje_kraj');
//Redirect na homepage ako user rucno proba da ode na /soloEnd
Route::get('/soloEnd', function() {return redirect()->route('homePage');});
Route::get('/soloResults', [BaseController::class, 'soloKucanjePrikazRezultata'])->name('solo_kucanje_rezultati');

Route::get('/daily', [UserController::class, 'dailyKucanje'])->name('daily_kucanje');
Route::post('/dailyEnd', [UserController::class, 'dailyKucanjeKraj'])->name('daily_kucanje_kraj');
//Redirect na homepage ako user rucno proba da ode na /dailyEnd
Route::get('/dailyEnd', function() {return redirect()->route('homePage');});
Route::get('/dailyResults', [UserController::class, 'dailyKucanjePrikazRezultata'])->name('daily_kucanje_rezultati');
Route::get('/dailyChange', [UserController::class, 'promeniDaily'])->name('promeni_daily');



Route::get('/texts/create', [TextsController::class, 'create'])->name('create_text')->middleware("auth");
Route::post('/texts/store', [TextsController::class, 'store'])->name('store_text')->middleware("auth");
Route::delete('/texts/destroy/{id}', [TextsController::class, 'destroy'])->name('destroy_text')->middleware("auth");
Route::get('/texts/show/{id}', [TextsController::class, 'show'])->name('show_text');
Route::get('/texts/edit/{id}', [TextsController::class, 'edit'])->name('edit_text')->middleware("auth");
Route::post('/texts/update', [TextsController::class, 'update'])->name('update_text')->middleware("auth");

Route::get('/texts/ranks/{id}', [TextsController::class, 'rankList'])->name('rank_list');
Route::get('/texts/friendly_ranks/{id}', [TextsController::class, 'friendlyRankList'])->name('friendly_rank_list')->middleware("auth");

Route::get('/rankList', [TextsController::class, 'globalRankList'])->name('global_rank_list');
