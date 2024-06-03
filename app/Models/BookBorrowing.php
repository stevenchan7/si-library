<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_child_id',
        'return_deadline',
        'status'
    ];

    protected $casts = [
        'status' => Status::class
    ];
}
