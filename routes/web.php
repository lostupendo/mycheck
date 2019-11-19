<?php

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

use App\Http\Controllers\MyCheckAuthController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');

Route::get('/login',            [MyCheckAuthController::class, 'login'])->name('login');
Route::post('/login',           [MyCheckAuthController::class, 'doLogin']);

Route::get('/register',         [MyCheckAuthController::class, 'register'])->name('register');

