<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishedGoodsTable extends Migration
{
    public function up()
    {
        Schema::create('finished_goods', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_id');
            $table->string('part_name');
            $table->string('part_number');
            $table->string('type_package');
            $table->integer('qty_package')->default(0); // Add default value if needed
            $table->string('project')->nullable();
            $table->string('customer');
            $table->string('area_fg')->nullable();
            $table->string('satuan');
            $table->integer('stok_awal')->default(0); // Add new column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('finished_goods');
    }
}