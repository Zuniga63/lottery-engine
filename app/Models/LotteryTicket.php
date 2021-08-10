<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryTicket extends Model
{
  use HasFactory;
  protected $table = 'lottery_ticket';
  protected $fillable = ['seller_id', 'customer_id', 'first_option', 'second_option', 'payment_date'];
  protected $guarded = ['id'];

  public function payments()
  {
    return $this->hasMany(LotteryTicketPayment::class);
  }

  public function seller()
  {
    return $this->belongsTo(Seller::class, 'seller_id');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }
}
