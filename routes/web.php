<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\CreateProject;
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

// Authentication

Route::middleware('guest')->group(function() {
    Route::name('login')->get('/', [AuthController::class, 'login']);
    Route::get('login', [AuthController::class, 'login']);
    Route::name('login_post')->post('login_post', [AuthController::class, 'login_post']);
});