<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $now = Carbon::now()->format('Y-m-d H:i:s');
    
    DB::table('users')->insert([
      'id'                => 1,
      'name'              => "Andrés Felipe Zúñiga",
      'email'             => "admin@admin.com",
      'email_verified_at'    => $now,
      'password'          => Hash::make('admin'),
      'created_at'        => $now,
      'updated_at'        => $now,
    ]);
  }
}
