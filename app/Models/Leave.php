<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class leave extends Authenticatable
{
  use HasFactory;

  protected $table = 'leave';

  protected $fillable = ['id', 'staffid', 'startDate', 'endDate', 'reason', 'status', 'type'];

  public $timestamps = false;

  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staffid');
  }
}
