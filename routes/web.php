<?php

use App\Http\Controllers\BookBorrowingController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
})->name('home');

Route::prefix('auth')->group(function () {
    Route::post('/logout', function () {
        return;
    })->name('logout');

    Route::post('/login', LoginController::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('borrow-book', [BookBorrowingController::class, 'store'])->name('borrow.book.post');
});

// Book route
Route::resource('/books', BookController::class);
