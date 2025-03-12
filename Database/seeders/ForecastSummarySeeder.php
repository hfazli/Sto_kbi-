<?php

namespace Database\Seeders;

use App\Models\ForecastSummary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForecastSummarySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run()
  {
    ForecastSummary::factory()->count(100)->create(); // Generate 10 entries
  }
}
