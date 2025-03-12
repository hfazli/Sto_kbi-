<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('forecast_summaries', function (Blueprint $table) {
      $table->id();
      $table->string('customer_name');
      $table->string('dec')->nullable();
      $table->integer('total_part')->nullable();
      $table->string('stock_day')->nullable();
      $table->date('date')->nullable();
      $table->integer('stock_value')->nullable();
      $table->decimal('avg', 8, 2)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('forecast_summaries');
  }
};
