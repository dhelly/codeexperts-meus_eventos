<?php

use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     $events = Event::all();
//     return view('welcome', [
//         'events' => $events
//     ]);
// });

// Home
Route::get('/', [HomeController::class, 'index']);
Route::get('eventos/{slug}', [HomeController::class, 'show'])->name('event.single');

// Event
Route::prefix('/admin')->name('admin.')->group(function () {
    Route::prefix('/events')->name('events.')->group(function () {

        Route::get('/', [
                \App\Http\Controllers\Admin\EventController::class,
                'index'])->name('index');

        Route::get('/create', [
                \App\Http\Controllers\Admin\EventController::class,
                'create'
            ])->name('create');
        Route::post('/store', [
                \App\Http\Controllers\Admin\EventController::class,
                'store'
            ])->name('store');

        Route::get('/{event}/edit', [
                \App\Http\Controllers\Admin\EventController::class,
                'edit'
            ])->name('edit');
        Route::post('/update/{event}', [
                \App\Http\Controllers\Admin\EventController::class,
                'update'
                ])->name('update');

        Route::get('/destroy/{event}', [
                \App\Http\Controllers\Admin\EventController::class,
                'destroy'
            ])->name('destroy');
    });
});
