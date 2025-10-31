<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActivityLog extends Model
{
  use HasFactory;

  protected $table = 'activity_logs';

  protected $fillable = [
    'user_id',
    'user_name',
    'role',
    'action',
    'details',
    'status',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
