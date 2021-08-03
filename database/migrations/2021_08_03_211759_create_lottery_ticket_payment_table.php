<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteryTicketPaymentTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('lottery_ticket_payment', function (Blueprint $table) {
      $table->id();
      $table->foreignId('lottery_ticket_id')->constrained('lottery_ticket');
      $table->foreignId('seller_id')->constrained('seller');
      $table->foreignId('customer_id')->constrained('customer');
      $table->decimal('amount', 5, 0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('lottery_ticket_payment');
  }
}
