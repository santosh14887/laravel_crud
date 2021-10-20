<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::resource('authors', App\Http\Controllers\AuthorsController::class);
Route::resource('books', App\Http\Controllers\BooksController::class);
Route::get('books/{id}/review', [App\Http\Controllers\BooksController::class, 'review'])->name('review');
Route::put('books/{id}/review', [App\Http\Controllers\BooksController::class, 'addreview'])->name('add_review');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

