<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookBorrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_child_id',
        'return_deadline',
        'status'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(BookChild::class, 'book_child_id');
    }
}
