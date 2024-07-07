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
    public function GenerateGeneralReport(Request $request)
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
            'bookBorrowingPerMonth' => $bookBorrowingPerMonth,
        );

        $pdf = Pdf::loadView('pdf.report', $data);
        return $pdf->stream();
    }

    public function GenerateLogReport(Request $request)
    {
        $today = date("Y-m-d H:i:s");
        $borrowingLog = BookBorrowing::all();
        $books = Book::all();

        $data = array(
            'date' => $today,
            'borrowingLog' => $borrowingLog,
            'books' => $books
        );

        $pdf = Pdf::loadView('pdf.borrowinglog', $data);
        return $pdf->stream();
    }

    public function GenerateBookReport(Request $request)
    {
        $today = date("Y-m-d H:i:s");
        $books = Book::all();

        $data = array(
            'date' => $today,
            'books' => $books
        );

        $pdf = Pdf::loadView('pdf.bookreport', $data);
        return $pdf->stream();
    }

    public function GenerateBookLogReport(Request $request, Book $book)
    {
        $today = date("Y-m-d H:i:s");
        $parentBookId = $book->id;
        $borrowings = BookBorrowing::whereHas('book', function ($query) use ($parentBookId) {
            $query->where('book_id', $parentBookId);
        })->orderBy('updated_at', 'asc')->get();

        $data = array(
            'date' => $today,
            'book' => $book,
            'borrowings' => $borrowings
        );

        $pdf = Pdf::loadView('pdf.booklogreport', $data);
        return $pdf->stream();
    }
}
