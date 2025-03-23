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
    Schema::table('Forecast', function (Blueprint $table) {
      $table->double('forecast_day')->default(0)->after('forecast_qty');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('Forecast', function (Blueprint $table) {
      $table->dropColumn('forecast_day');
    });
  }
};
