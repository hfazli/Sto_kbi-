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
      $table->string('inventory_id')->nullable()->change();
      if (!Schema::hasColumn('report_sto', 'part_name')) {
        $table->string('part_name')->nullable();
      }
      if (!Schema::hasColumn('report_sto', 'part_number')) {
        $table->string('part_number')->nullable();
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('report_sto', function (Blueprint $table) {
      $table->string('inventory_id')->nullable(false)->change();

      if (Schema::hasColumn('report_sto', 'part_name')) {
        $table->dropColumn('part_name');
      }
      if (Schema::hasColumn('report_sto', 'part_number')) {
        $table->dropColumn('part_number');
      }
    });
  }
};
