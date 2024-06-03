<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookChild extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'book_id',
        'status'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_borrowings');
    }
}
