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
    'return_requested_at',
    'status',
    'days_overdue',
    'fee',
    'approved_by',
    'return_approved_by',
  ];

  protected $dates = ['borrowed_at', 'returned_at', 'return_requested_at', 'due_date', 'created_at', 'updated_at'];

  protected $casts = [
    'fee' => 'float',
    'days_overdue' => 'integer',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function book()
  {
    return $this->belongsTo(Book::class);
  }

  public function approver()
  {
    return $this->belongsTo(User::class, 'approved_by');
  }

  public function returnApprover()
  {
    return $this->belongsTo(User::class, 'return_approved_by');
  }
}
