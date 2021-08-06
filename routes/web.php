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
Route::middleware('auth')->prefix('/admin')->name('admin.')->group(function () {

    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::resource('events.photos', \App\Http\Controllers\Admin\EventPhotoController::class);

    //Event another options
    // Route::resources(
    //     [
    //         'events' => \App\Http\Controllers\Admin\EventController::class,
    //         'events.photos' => \App\Http\Controllers\Admin\EventPhotoController::class
    //     ],
    //     [
    //         'except' => ['destroy']
    //     ]
    // );
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
