<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $books = Book::all();
        $categories = Category::all();

        $bookTotal = $books->count();
        $categoryTotal = $categories->count();

        $totalStock = Book::sum('stock');
        $totalAvailableStock = Book::sum('available_stock');
        $totalUnavailableStock = $totalStock - $totalAvailableStock;
        $stock = array($totalAvailableStock, $totalUnavailableStock);

        // Menghitung data peminjamam buku selama 6 bulan terakhir
        // Tentukan tanggal 6 bulan yang lalu
        $sixMonthsAgo = Carbon::now()->subMonths(6)->startOfMonth();

        // Query untuk menghitung jumlah record yang dikelompokkan berdasarkan bulan
        $bookBorrowingPerMonth = BookBorrowing::where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->get();

        // dd($bookBorrowingPerMonth);

        return view('index')
            ->with('bookTotal', $bookTotal)
            ->with('categoryTotal', $categoryTotal)
            ->with('stock', $stock)
            ->with('bookBorrowingPerMonth', $bookBorrowingPerMonth);
    }
}
