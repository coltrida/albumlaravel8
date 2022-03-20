<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::resource('albums', AlbumController::class);
Route::resource('photos', PhotoController::class);

Route::get('/users', [HomeController::class, 'users'])->name('users');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';