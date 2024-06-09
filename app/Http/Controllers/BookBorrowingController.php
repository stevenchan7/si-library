<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use App\Models\BookChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookBorrowingController extends Controller
{
    public function __construct(protected $statuses = null)
    {
        $this->statuses = array('pending', 'ready', 'taken', 'returned', 'canceled', 'rejected');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $borrowings = array();

        // Get book based on user role
        if (in_array($user->role->title, array('librarian', 'admin'))) {
            foreach ($this->statuses as $status) {
                $borrowings[$status] = BookBorrowing::where('status', $status)->get();
            }
        } else {
            foreach ($this->statuses as $status) {
                $borrowings[$status] = BookBorrowing::where('user_id', $user->id)->where('status', $status)->get();
            }
        }

        return view('book.borrowing-book')
            ->with('borrowings', $borrowings)
            ->with('role', Auth::user()->role->title);
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
            'bookId' => ['required', 'numeric', 'exists:books,id']
        ]);

        $bookId = $validated['bookId'];

        // Cek apakah user masih punya slot
        if ($request->user()->borrowing_limit < 1) {
            // return response()->json([
            //     'success' => false,
            //     'msg' => 'Exceeding borrowing limit'
            // ]);

            return back()->with('error', 'Exceeding borrowing limit');
        }

        // Cek apakah user sedang meminjam buku ini
        $userBooks = $request->user()->books;
        foreach ($userBooks as $book) {
            if ($book->parent->id == $validated['bookId']) {
                return back()->with('error', 'Already borrowed this book');
            }
        }

        // Check book's stock
        $book = Book::findOrFail($bookId);

        if (!$book) {
            // return response()->json([
            //     'success' => false,
            //     'msg' => 'Book not found'
            // ]);
            return back()->with('error', 'Book not found');
        }

        if ($book->stock < 1) {
            // return response()->json([
            //     'success' => false,
            //     'msg' => 'Book not available'
            // ]);
            return back()->with('error', 'Book not available');
        }

        // Find available book's child
        $bookChild = $book->children()->where('status', 'available')->first();

        if (!$bookChild) {
            // return response()->json([
            //     'success' => false,
            //     'msg' => 'Book not available'
            // ]);
            return back()->with('error', 'Book not available');
        }

        // Create book borrowing
        BookBorrowing::create([
            'user_id' => $request->user()->id,
            'book_child_id' => $bookChild->id,
        ]);

        // Reduce book's available stock
        $book->available_stock -= 1;
        $book->save();
        // Change status
        $bookChild->status = 'unavailable';
        $bookChild->save();

        // return response()->json([
        //     'success' => true,
        //     'msg' => 'Book added successfully'
        // ]);
        return back()->with('success', 'Book added successfully');
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
    public function update(Request $request)
    {
        // Update book borrowing status
        $validated = $request->validate([
            'id' => ['required', 'numeric', 'exists:book_borrowings,id'],
            'status' => ['required', Rule::in($this->statuses)]
        ]);

        $borrowing = BookBorrowing::findOrFail($validated['id']);

        $role = $request->user()->role->title;

        if ($validated['status'] == 'ready' || $validated['status'] == 'taken' || $validated['status'] == 'returned' || $validated['status'] == 'rejected') {
            if ($role == 'librarian' || $role == 'admin') {
                $borrowing->status = $validated['status'];
                $borrowing->update();
                return back()->with('success', 'Update status success');
            } else {
                return back()->with('error', 'Unauthorized');
            }
        }

        if ($validated['status'] == 'canceled') {
            if ($request->user()->id == $borrowing->user_id || $role == 'librarian' || $role == 'admin') {
                $borrowing->status = $validated['status'];
                $borrowing->update();
                return back()->with('success', 'Update status success');
            } else {
                return back()->with('error', 'Unauthorized');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Delete book borrowing
        $validated = $request->validate([
            'id' => ['required', 'numeric', 'exists:book_borrowings,id'],
        ]);

        $borrowing = BookBorrowing::findOrFail($validated['id']);

        $book = BookChild::findOrFail($borrowing->book_child_id);
        $book->status = 'available';
        $book->save();

        $book->parent->available_stock++;
        $book->parent->save();

        $borrowing->delete();

        return back()->with('success', 'Delete success');
    }
}
