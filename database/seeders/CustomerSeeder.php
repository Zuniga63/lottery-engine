<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $customers = [
      ['first_name' => 'Omaira', 'last_name' => 'Hoyos vega', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Maria Daniela', 'last_name' => 'Toncel Hoyos', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Juan David', 'last_name' => 'Ariza Hoyos', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Lucy Esther', 'last_name' => 'Hoyos Vega', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Andrés Felipe', 'last_name' => 'Zuñiga Hoyos', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Jesus Alberto', 'last_name' => 'Zuñiga Hoyos', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Liz', 'last_name' => 'Hoyos Vega', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Jhony Erly', 'last_name' => 'Cuadro Hoyós', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Jorge Luis', 'last_name' => 'Hoyos Vega', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Carmen Cecilía', 'last_name' => 'Gutierres', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Jorge Eliecer', 'last_name' => 'Hoyos Vega', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Liliana', 'last_name' => 'Arías Restrepo', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Neila Patricia', 'last_name' => 'Hoyos Vega', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'German', 'last_name' => 'Manzano', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Arelis María', 'last_name' => 'Hoyos Vega', 'address' => 'Calle 8 #6-22'],
      ['first_name' => 'Fernando', 'last_name' => 'Mendez', 'address' => 'Calle 8 #6-22'],
    ];

    $now = Carbon::now()->format('Y-m-d H:i:s');

    foreach ($customers as $customer) {
      DB::table('customer')->insert([
        'first_name' => $customer['first_name'],
        'last_name' => $customer['last_name'],
        'address' => $customer['address'],
        'created_at' => $now,
        'updated_at' => $now,
      ]);
    }
  }
}
