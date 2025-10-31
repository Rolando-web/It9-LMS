<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTransaction extends Model
{
  use HasFactory;

  protected $table = 'book_transactions';

  protected $fillable = [
    'user_id',
    'book_id',
    'borrowed_at',
    'due_date',
    'returned_at',
    'status',
    'days_overdue',
    'fee',
  ];

  protected $dates = ['borrowed_at', 'returned_at', 'due_date', 'created_at', 'updated_at'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function book()
  {
    return $this->belongsTo(Book::class);
  }
}
