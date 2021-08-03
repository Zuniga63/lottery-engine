<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteryTicketTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('lottery_ticket', function (Blueprint $table) {
      $table->id();
      $table->foreignId('seller_id')->constrained('seller');
      $table->foreignId('customer_id')->constrained('customer');
      $table->string('fisrt_option', 3);
      $table->string('second_option', 3);
      $table->unique(['fisrt_option', 'second_option']);
      $table->timestamp('paymen_date')->nullable();
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
    Schema::dropIfExists('lottery_ticket');
  }
}
