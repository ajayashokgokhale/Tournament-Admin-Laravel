<?php

use App\Http\Controllers\Admin\ContestsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PlayersController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\FranchisesController;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    //We will add admin routes here

});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/home',[\App\Http\Controllers\Admin\BasketballAdmin::class, 'home'])->name('admin.home');

    Route::get('/franchises',[FranchisesController::class, 'home'])->name('admin.franchises');
    Route::post('/franchises', [FranchisesController::class, 'newFranchise'])->name('admin.franchises.store');
    Route::match(['get', 'post'], '/franchises/{id}/edit', [FranchisesController::class, 'edit'])->name('admin.franchises.edit');
    Route::post('/franchises/{id}/delete', [FranchisesController::class, 'delete'])->name('admin.franchises.delete');

    // New routes for players
    Route::get('/players', [PlayersController::class, 'home'])->name('admin.players');
    Route::post('/players', [PlayersController::class, 'newPlayer'])->name('admin.players.store');
    Route::match(['get', 'post'], '/players/{id}/edit', [PlayersController::class, 'edit'])->name('admin.players.edit');
    Route::post('/players/{id}/delete', [PlayersController::class, 'delete'])->name('admin.players.delete');

    // New routes for events
    Route::get('/events', [EventsController::class, 'home'])->name('admin.events');
    Route::post('/events', [EventsController::class, 'newEvent'])->name('admin.events.store');
    Route::match(['get', 'post'], '/events/{id}/edit', [EventsController::class, 'edit'])->name('admin.events.edit');
    Route::post('/events/{id}/delete', [EventsController::class, 'delete'])->name('admin.events.delete');


    // Other routes...
    Route::get('/contests', [ContestsController::class, 'home'])->name('admin.contests');
    Route::post('/contests', [ContestsController::class, 'newContest'])->name('admin.contests.store');
    Route::match(['get', 'post'], '/contests/{id}/edit', [ContestsController::class, 'update'])->name('admin.contests.update');
    Route::post('/contests/{id}/delete', [ContestsController::class, 'delete'])->name('admin.contests.delete');

});

Route::get('/test-image', function () {
    $img = Intervention\Image\Facades\Image::make(public_path('images/logo.png'))->resize(300, 200);
    return $img->response('jpg');
});

require __DIR__.'/auth.php';
