<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PhotoController;


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

Route::get('/', [TestController::class, 'getAll']);

// Route::get('/upload', function () {
//     return view('upload');
// })->middleware(['auth'])->name('upload');

// Route::get('/upload/{album}', [TestController::class, 'testAuth'])->middleware(['auth']);
Route::group(['prefix' => 'upload', 'middleware' => 'auth'], function()
{
    Route::get('/', [AlbumController::class, 'uploadview'])->name('uploadhome');
    Route::get('/albums/{album}', [AlbumController::class, 'getAlbum']);
    Route::post('/albums', [AlbumController::class, 'storeAlbum']);
    Route::delete('/albums/{album}', [AlbumController::class, 'deleteAlbum']);
    Route::post('/albums/uploadMultiple', [AlbumController::class, 'uploadMultiple']);
    Route::put('/albums/photo-edit', [PhotoController::class, 'editImage']);
    Route::delete('/photos/{photo}', [PhotoController::class, 'deleteImage']);
    Route::get('/preview/{album}', [AlbumController::class, 'previewUpload']);
});
require __DIR__.'/auth.php';
