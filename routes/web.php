<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;
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

Route::middleware('guest')->group(function () {
    Route::name('login')->get('/', [AuthController::class, 'login']);
    Route::get('login', [AuthController::class, 'login']);
    Route::name('login_post')->post('login_post', [AuthController::class, 'login_post']);
});
Route::middleware('auth')->group(function () {

    Route::get('logout', [AuthController::class, 'logout']);
    Route::name('report.')->prefix('report')->group(function () {

        Route::name('project')->get('project', [ReportController::class, 'project']);
        Route::name('report')->get('report', [ReportController::class, 'report']);
    });
});

Route::get('test', function() {

    // $items = [
    //     'Dorazon',
    //     'Dorazon 1',
    //     'Dorazon 2',
    //     'Dorazon 3',
    // ];

    // $html = view('reports.test', compact('items'))->render();
    // $filename = '' Str::random(10) . '.pdf';
    // $pdf = Browsershot::html($html)
    // ->format('A4');
    // ->save($filename);

    // return response()->download($filename);

    return view('reports.summary', [
        'title' => 'Summary - Report 1',
    ]);
});

