<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BookController::class, 'index']);
Route::post('/upload', [BookController::class, 'upload']);
Route::put('/index/{id}', 'App\Http\Controllers\BookController@update')->name('book.update')->middleware('web');
Route::get('/upload-form', function () {
    return view('create');
});
Route::resource('index', BookController::class)->only(['store', 'update']);
