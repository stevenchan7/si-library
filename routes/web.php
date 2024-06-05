<?php

use App\Http\Controllers\BookBorrowingController;
use App\Http\Controllers\BookChildController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Models\BookChild;
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

// Category route
Route::resource('/categories', CategoryController::class);

// Add child route
Route::post('/books/{books:id}/add', [BookChildController::class, 'addChild']);
Route::post('/books/{books:id}/delete',[BookChildController::class, 'deleteChild']);
