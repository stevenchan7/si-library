<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookChild;
use Illuminate\Http\Request;

class BookChildController extends Controller
{
    public function addChild(Book $books, Request $request)
    {
        $new_books = $request->validate([
            'numberOfBooks' => ['required', 'min:1', 'integer']
        ]);
 
        $datas = [];

        for($i = 0; $i < $request->numberOfBooks; $i++)
        {
            $datas[] = [
                'book_id' => $books->id,
                'status' => 'available'
            ];
        }
        BookChild::insert($datas);
        BookController::updateStock($books, $request->numberOfBooks);

        return redirect('/books/'.$books->id)->with('success', 'Book(s) added!');
    }

    public function deleteChild(Request $request, Book $books)
    {

        $data = [
            'book_id' => $request->parent_book_id,
            'status' => 'available'
        ];
        
        BookChild::destroy($request->child_id);
        BookController::updateStock($books);

        return redirect('/books/'.$books->id)->with('success', 'Book deleted!');
    }
}
