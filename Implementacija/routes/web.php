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

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/texts', [UserController::class, 'showTexts'])->name('texts');
Route::get('/textsearch', [UserController::class, 'searchTexts'])->name('search_texts');

//Ove tri rute treba da idu na BaseController (kad bude napravljen)
Route::get('/solo', [BaseController::class, 'soloKucanje'])->name('solo_kucanje');
Route::get('/solo/{id}', [BaseController::class, 'soloKucanje'])->name('solo_kucanje');
//Promeni u POST!!!
Route::get('/soloEnd', [BaseController::class, 'soloKucanjeKraj'])->name('solo_kucanje_kraj');
Route::get('/soloResults', [BaseController::class, 'soloKucanjePrikazRezultata'])->name('solo_kucanje_rezultati');


Route::get('/texts/create', [TextsController::class, 'create'])->name('create_text')->middleware("auth");
Route::post('/texts/store', [TextsController::class, 'store'])->name('store_text')->middleware("auth");
Route::delete('/texts/destroy/{id}', [TextsController::class, 'destroy'])->name('destroy_text')->middleware("auth");
Route::get('/texts/show/{id}', [TextsController::class, 'show'])->name('show_text');
Route::get('/texts/edit/{id}', [TextsController::class, 'edit'])->name('edit_text')->middleware("auth");
Route::post('/texts/update', [TextsController::class, 'update'])->name('update_text')->middleware("auth");
