<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Admin::create([
      'username' => 'adminKBI',
      'first_name' => 'Admin',
      'last_name' => 'User',
      'password' => Hash::make('admin'),
      'role' => 'admin',
      'id_card_number' => '000000',
      'department' => '-',
    ]);
  }
}
