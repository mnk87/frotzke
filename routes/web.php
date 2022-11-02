<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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
    Route::get('/', [TestController::class, 'uploadview']);
});
require __DIR__.'/auth.php';
