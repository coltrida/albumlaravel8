<?php

use App\Http\Controllers\Admin\AdminUserController;

Route::view('/', 'layouts/admin')->name('admin');
Route::resource('users', AdminUserController::class);
Route::delete('users/forceDelete/{id}', [AdminUserController::class, 'forceDelete'])->name('users.forceDelete');
Route::get('users/restore/{id}', [AdminUserController::class, 'restore'])->name('users.restore');
