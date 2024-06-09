<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_borrowings');
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(BookBorrowing::class);
    }
}
