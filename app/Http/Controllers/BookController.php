<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('book.index', [
            'books' => Book::all(),
            'role' => Auth::user()->role->title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required'],
            'isbn' => ['required', 'unique:books'],
            'author' => ['required'],
            'publisher' => ['required'],
            'release_date' => ['required'],
            'category_id' => ['required']
        ]);

        $validatedData['available_stock'] = 0;
        $validatedData['stock'] = 0;

        //masukkan data ke database
        Book::create($validatedData);

        return redirect('/books')->with('success', 'New book added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('book.show', [
            'book' => $book,
            'book_childrens' => $book->children()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('book.edit', [
            'book' => $book,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $rules = [
            'title' => ['required'],
            'author' => ['required'],
            'publisher' => ['required'],
            'release_date' => ['required'],
            'category_id' => ['required']
        ];

        //jika user mengganti isbn
        if ($request->isbn != $book->isbn) {
            $rules['isbn'] = ['required', 'unique:books'];
        }

        $validatedData = $request->validate($rules);

        //masukkan data ke database
        Book::where('id', $book->id)->update($validatedData);

        return redirect('/books')->with('success', 'Book has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        Book::destroy($book->id);
        return redirect('/books')->with('success', 'Book has been deleted');
    }

    public static function updateStock(Book $book)
    {
        $data = [
            'stock' => $book->children()->count(),
            'available_stock' => $book->children()->where('status', 'available')->count()
        ];

        //masukkan data ke database
        Book::where('id', $book->id)->update($data);
    }
}
