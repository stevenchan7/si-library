<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookChild;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $bookId = rand(1, 3);

            BookChild::create([
                'book_id' => $bookId,
                'status' => 'available',
            ]);

            $book = Book::findOrFail($bookId);
            $book->stock++;
            $book->available_stock++;
            $book->save();
        }
    }
}
