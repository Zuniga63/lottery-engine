<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
  use HasFactory;
  protected $table = 'seller';
  protected $fillable = ['first_name', 'last_name'];
  protected $guarded = ['id'];

  public function tickets()
  {
    return $this->hasMany(LotteryTicket::class);
  }

  public function payments()
  {
    return $this->hasMany(LotteryTicketPayment::class);
  }
}
