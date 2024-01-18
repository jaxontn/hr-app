<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class editleave extends Authenticatable
{
  use HasFactory;

  protected $table = 'editleave';

  protected $fillable = ['id', 'staffid', 'action', 'amount', 'reason', 'status', 'created_date'];

  public $timestamps = false;

  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staffid');
  }
}
