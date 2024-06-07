<?php

use App\Http\Controllers\BookBorrowingController;
use App\Http\Controllers\BookChildController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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

Route::prefix('auth')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('/login', function () {
        return view('auth/login');
    })->name('login');

    Route::post('/login', LoginController::class)->name('authenticate');
});

Route::get('/', function () {
    return view('index');
})->middleware('auth')->name('home');

Route::prefix('/books')->middleware('auth')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');
});

Route::middleware('auth')->group(function () {
    Route::post('borrow-book', [BookBorrowingController::class, 'store'])->name('borrow.book.post');
});

Route::middleware(['auth', 'auth.librarian'])->group(function () {
    // Book route
    Route::prefix('/books')->group(function () {
        Route::get('/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    // Category route
    Route::resource('/categories', CategoryController::class);

    // Add child route
    Route::post('/books/{book}/add', [BookChildController::class, 'addChild'])->name('books.addChild');
    Route::post('/books/{book}/delete', [BookChildController::class, 'deleteChild'])->name('books.delChild');
});
