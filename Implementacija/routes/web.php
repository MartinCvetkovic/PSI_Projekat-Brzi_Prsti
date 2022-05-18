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

