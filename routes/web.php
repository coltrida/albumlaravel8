<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/testMail', [HomeController::class, 'testMail'])->name('testMail');
Route::get('/testMailMd', [HomeController::class, 'testMailMd'])->name('testMailMd');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::resource('albums', AlbumController::class);
    Route::resource('photos', PhotoController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/users', [HomeController::class, 'users'])->name('users');
    Route::get('photos/create/{album}', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('filtraAlbum', [AlbumController::class, 'filtra'])->name('albums.filtra');
});

Route::group(['prefix' => 'gallery'], function (){
    Route::get('/', [GalleryController::class, 'index']);
    Route::get('albums', [GalleryController::class, 'index'])->name('gallery.album');
    Route::get('album/{album}/images', [GalleryController::class, 'showAlbumImages'])->name('gallery.album.images');
    Route::get('categories/{category}/albums', [GalleryController::class, 'showCategoryAlbums'])->name('gallery.categories.albums');
});

require __DIR__.'/auth.php';
