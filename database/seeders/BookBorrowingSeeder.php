<?php

namespace Database\Seeders;

use App\Models\BookBorrowing;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookBorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create multiple records
        for ($i = 0; $i < 100; $i++) {
            BookBorrowing::create([
                'user_id' => rand(1, 3),
                'book_child_id' => rand(1, 5),
                'status' => 'done',
                'created_at' => Carbon::now()->subMonths(rand(0, 5))->subDays(rand(0, 30))
            ]);
        }
    }
}
