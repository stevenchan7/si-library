<?php

use App\Http\Controllers\BookBorrowingController;
use App\Http\Controllers\BookChildController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenerateReport;
use App\Http\Controllers\GenerateReportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\BookChild;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware(['auth', 'auth.admin'])->group(function () {
    // User management
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/{user:id}', [UserController::class, 'update'])->name('update_role');
    // Report
    Route::get('/generate-report', [GenerateReportController::class, 'GenerateGeneralReport'])->name('generateReport');
    Route::get('/generate-log-report', [GenerateReportController::class, 'GenerateLogReport'])->name('generateLogReport');
    Route::get('/generate-book-report', [GenerateReportController::class, 'GenerateBookReport'])->name('generateBookReport');
    Route::get('/generate-book-log/{book:id}', [GenerateReportController::class, 'GenerateBookLogReport']);
});

Route::prefix('auth')->group(function () {
    // Register
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('new_user');
    // Login
    Route::get('/login', function () {
        return view('auth/login');
    })->name('login');
    Route::post('/login', LoginController::class)->name('authenticate');
    // Logout
    Route::post('/logout', LogoutController::class)->name('logout');
});

// Dashboard
Route::get('/', DashboardController::class)->middleware('auth')->name('home');

Route::get('/books/create', [BookController::class, 'create'])
    ->middleware(['auth', 'auth.librarianOrAdmin'])
    ->name('books.create');

Route::prefix('/books')->middleware('auth')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');
});

Route::middleware('auth')->group(function () {
    Route::get('borrow-book', [BookBorrowingController::class, 'index'])->name('borrow.index');
    Route::post('borrow-book', [BookBorrowingController::class, 'store'])->name('borrow.post');
    Route::post('borrow-book/update', [BookBorrowingController::class, 'update'])->name('borrow.update');
});

Route::middleware(['auth', 'auth.librarianOrAdmin'])->group(function () {
    // Book route
    Route::prefix('/books')->group(function () {
        // Route::get('/create', [BookController::class, 'create'])->name('books.create'); Move to top
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

    // Borrow book control
    Route::delete('borrow-book', [BookBorrowingController::class, 'destroy'])->name('borrow.delete');
});
