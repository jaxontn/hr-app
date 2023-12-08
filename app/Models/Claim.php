<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class claim extends Authenticatable
{
  use HasFactory;

  protected $table = 'claim';

  protected $fillable = ['id', 'staffid', 'amount', 'reason', 'status', 'attachment', 'remark_manager', 'remark_finance', 'remark_director', 'type'];

  public $timestamps = false;

  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staffid');
  }
}
