<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('customer', function (Blueprint $table) {
      $table->id();
      $table->string('first_name', 45);
      $table->string('last_name', 45)->nullable();
      $table->string('nit', 20)->unique()->nullable();
      $table->string('phone', 20)->nullable();
      $table->string('address', 100)->nullable();
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
    Schema::dropIfExists('customer');
  }
}
