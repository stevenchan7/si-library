<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
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

        // dd($stock);

        return view('index')
            ->with('bookTotal', $bookTotal)
            ->with('categoryTotal', $categoryTotal)
            ->with('stock', $stock);
    }
}
