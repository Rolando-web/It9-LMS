<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    //
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'category',
        'isbn',
        'publish_date',
        'copies',
        'image',
        'user_id',
    ];

    /**
     * Get the user who added this book
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
