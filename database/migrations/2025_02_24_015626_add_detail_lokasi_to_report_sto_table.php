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
    Schema::table('report_sto', function (Blueprint $table) {
      if (!Schema::hasColumn('report_sto', 'detail_lokasi')) {
        $table->string('detail_lokasi')->nullable(); // Add the detail_lokasi column
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('report_sto', function (Blueprint $table) {
      if (Schema::hasColumn('report_sto', 'detail_lokasi')) {
        $table->dropColumn('detail_lokasi'); // Drop the detail_lokasi column if the migration is rolled back
      }
    });
  }
};