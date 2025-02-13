<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Hedi',
            'last_name' => 'Fazli',
            'username' => 'edi',
            'id_card_number' => 'K00298',
            'password' => Hash::make('fazli'),
            'last_login' => Carbon::now(),
            'role' => 'user',
            'department' => 'PPIC', // Menambahkan department
        ]);

        User::create([
            'first_name' => 'Pulan',
            'last_name' => 'Fauzi',
            'username' => 'PulFauzi',
            'id_card_number' => 'k0',
            'password' => Hash::make('password123'),
            'last_login' => Carbon::now(),
            'role' => 'user',
            'department' => '', // Menambahkan department
        ]);
    }
}