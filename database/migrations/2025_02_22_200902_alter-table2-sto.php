<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTable2Sto extends Migration
{
    public function up()
    {
        Schema::table('report_sto', function (Blueprint $table) {
            if (!Schema::hasColumn('report_sto', 'checked_by')) {
                $table->string('checked_by')->nullable();
            }
            if (!Schema::hasColumn('report_sto', 'qty_per_box_2')) {
                $table->integer('qty_per_box_2')->nullable();
            }
            if (!Schema::hasColumn('report_sto', 'qty_box_2')) {
                $table->integer('qty_box_2')->nullable();
            }
            if (!Schema::hasColumn('report_sto', 'total_2')) {
                $table->integer('total_2')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('report_sto', function (Blueprint $table) {
            if (Schema::hasColumn('report_sto', 'checked_by')) {
                $table->dropColumn('checked_by');
            }
            if (Schema::hasColumn('report_sto', 'qty_per_box_2')) {
                $table->dropColumn('qty_per_box_2');
            }
            if (Schema::hasColumn('report_sto', 'qty_box_2')) {
                $table->dropColumn('qty_box_2');
            }
            if (Schema::hasColumn('report_sto', 'total_2')) {
                $table->dropColumn('total_2');
            }
        });
    }
}