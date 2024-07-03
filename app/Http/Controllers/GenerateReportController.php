<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use App\Models\Category;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GenerateReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
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

        $data = array(
            'bookTotal' => $bookTotal,
            'categoryTotal' => $categoryTotal,
            'stock' => $stock,
            'bookBorrowingPerMonth' => $bookBorrowingPerMonth
        );

        $pdf = Pdf::loadView('pdf.report', $data);
        return $pdf->stream();
    }
}