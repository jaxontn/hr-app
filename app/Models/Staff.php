<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class staff extends Authenticatable
{
  use HasFactory;

  protected $table = 'staff';

  protected $fillable = ['id', 'username', 'encrypted_password', 'salt', 'role', 'department', 'totalLeave', 'totalMed', 'usedLeave', 'usedMed', 'contact'];

  public $timestamps = false;

  public function therole()
  {
    return $this->belongsTo(Role::class, 'role');
  }

  public function thedept()
  {
    return $this->belongsTo(Department::class, 'department');
  }
}
