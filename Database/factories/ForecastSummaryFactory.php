<?php

namespace Database\Factories;

use App\Models\ForecastSummary;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ForecastSummary>
 */
class ForecastSummaryFactory extends Factory
{
  protected $model = ForecastSummary::class;

  public function definition(): array
  {
    return [
      'customer_name' => 'ADM-KAP',
      'dec' => 'Qty Part',
      'total_part' => 28, // From your Excel data
      'stock_day' => $this->faker->randomElement(['0', '0.5', '1', '1.5', '2', '2.5', '3', '>3']),
      'date' => Carbon::create(2025, 2, rand(1, 28))->format('Y-m-d'), // Random date in Feb 2025
      'stock_value' => $this->faker->randomElement([
        2,
        3,
        2,
        1,
        2,
        1,
        3,
        10,
        2,
        3,
        2,
        1,
        2,
        1,
        7,
        10,
        2,
        3,
        2,
        1,
        2,
        1,
        7,
        10,
        2,
        3,
        2,
        1,
        2,
        1,
        6,
        12,
        2,
        3,
        2,
        1,
        2,
        0,
        7,
        10,
        2,
        1,
        4,
        1,
        1,
        3,
        5,
        25
      ]), // Sample stock values
      'avg' => $this->faker->randomFloat(2, 0, 5), // Random average
    ];
  }
}
