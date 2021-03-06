<?php

use App\Http\Controllers\EnrollmentController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('eventos/{event:slug}', [HomeController::class, 'show'])->name('event.single');

//Enrollment
Route::prefix('/enrollment')->name('enrollment.')->group(function () {
    Route::get('/start/{event:slug}', [EnrollmentController::class, 'start'])->name('start');
    Route::get('/confirm', [EnrollmentController::class, 'confirm'])->name('confirm')->middleware('auth');

    Route::get('/process', [EnrollmentController::class, 'process'])->name('process')->middleware('auth');
});

// Event
Route::middleware('auth')->prefix('/admin')->name('admin.')->group(function () {

    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::resource('events.photos', \App\Http\Controllers\Admin\EventPhotoController::class)
        ->only(['index', 'store', 'destroy']);


    /** Outra forma de usar o middleware com only e except*/
    // Route::resource('events', \App\Http\Controllers\Admin\EventController::class)
    //         ->except(['edit', 'update']);

    // Route::resource('events', \App\Http\Controllers\Admin\EventController::class)
    //         ->only(['edit', 'update'])
    //         ->middleware(\App\Http\Middleware\CheckUserCanAccessEventToEditMiddleware::class);


    // Route::resource('events', \App\Http\Controllers\Admin\EventController::class)
    //         ->middleware('user.can.edit.event');

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
