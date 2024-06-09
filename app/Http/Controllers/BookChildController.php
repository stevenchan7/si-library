<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookChild;
use Illuminate\Http\Request;

class BookChildController extends Controller
{
    public function addChild(Book $book, Request $request)
    {
        $request->validate([
            'numberOfBooks' => ['required', 'min:1', 'integer']
        ]);

        $datas = [];

        for ($i = 0; $i < $request->numberOfBooks; $i++) {
            $datas[] = [
                'book_id' => $book->id,
                'status' => 'available'
            ];
        }
        BookChild::insert($datas);
        BookController::updateStock($book, $request->numberOfBooks);

        return redirect('/books/' . $book->id)->with('success', 'Book(s) added!');
    }

    public function deleteChild(Request $request, Book $book)
    {
        BookChild::destroy($request->child_id);
        BookController::updateStock($book);

        return redirect('/books/' . $book->id)->with('success', 'Book deleted!');
    }
}
