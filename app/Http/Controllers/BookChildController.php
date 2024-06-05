<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookChild;
use Illuminate\Http\Request;

class BookChildController extends Controller
{
    public function addChild(Request $request)
    {
        $data = [
            'book_id' => $request->parent_book_id,
            'status' => 'available'
        ];
        
        BookChild::create($data);

        return redirect('/books/'.$request->parent_book_id)->with('success', 'Book added!');
    }

    public function deleteChild(Request $request, Book $books)
    {

        $data = [
            'book_id' => $request->parent_book_id,
            'status' => 'available'
        ];
        
        BookChild::destroy($request->child_id);

        return redirect('/books/'.$books->id)->with('success', 'Book deleted!');
    }
}
