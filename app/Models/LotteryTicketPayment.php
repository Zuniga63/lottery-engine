<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryTicketPayment extends Model
{
  use HasFactory;
  protected $table = 'lottery_ticket_payment';
  protected $fillable = ['seller_id', 'customer_id', 'amount'];
  protected $guarded = ['id'];

  public function lotteryTicket()
  {
    return $this->belongsTo(LotteryTicket::class, 'lottery_ticket_id');
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
