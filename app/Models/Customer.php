<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use HasFactory;
  protected $table = 'customer';
  protected $fillable = ['first_name', 'last_name', 'nit', 'phone', 'address'];
  protected $guarded = ['id'];

  public function tickets()
  {
    return $this->hasMany(LotteryTicket::class);
  }
}
