<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use Illuminate\Http\Request;

class BookBorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => ['required', 'numeric', 'exists:books,id']
        ]);

        $bookId = $validated['book_id'];

        // Cek apakah user masih punya slot
        if ($request->user()->borrowing_limit < 1) {
            return response()->json([
                'success' => false,
                'msg' => 'Exceeding borrowing limit'
            ]);
        }

        // Check book's stock
        $book = Book::findOrFail($bookId);

        if (!$book) {
            return response()->json([
                'success' => false,
                'msg' => 'Book not found'
            ]);
        }

        if ($book->stock < 1) {
            return response()->json([
                'success' => false,
                'msg' => 'Book not available'
            ]);
        }

        // Find available book's child
        $bookChild = $book->children()->where('status', 'available')->first();

        if (!$bookChild) {
            return response()->json([
                'success' => false,
                'msg' => 'Book not available'
            ]);
        }

        // Create book borrowing
        $request->user()->books()->create([
            'book_child_id' => $bookChild->id,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Book added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
