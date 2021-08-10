<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $sellers = [
      ['first_name' => 'Omaira', 'last_name' => 'Hoyos Vega'],
      ['first_name' => 'María Daniela', 'last_name' => 'Toncel Hoyos'],
      ['first_name' => 'Arelis María', 'last_name' => 'Hoyos Vega'],
      ['first_name' => 'Liz Daris', 'last_name' => 'Hoyos Vega'],
      ['first_name' => 'Jorge Eliecer', 'last_name' => 'Hoyos Vega'],
      ['first_name' => 'Jorge Luis', 'last_name' => 'Hoyos Vega'],
      ['first_name' => 'Neila Patricia', 'last_name' => 'Hoyos Vega'],
    ];

    $now = Carbon::now()->format('Y-m-d H:i:s');
    foreach ($sellers as $seller) {
      DB::table('seller')->insert([
        'first_name' => $seller['first_name'],
        'last_name' => $seller['last_name'],
        'created_at' => $now,
        'updated_at' => $now,
      ]);
    }
  }
}
