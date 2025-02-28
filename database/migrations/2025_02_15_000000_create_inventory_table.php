<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_id');
            $table->string('part_name');
            $table->string('part_number');
            $table->string('type_package');
            $table->integer('qty_package')->default(0);
            $table->string('project')->nullable();
            $table->string('customer');
            $table->string('detail_lokasi')->nullable();
            $table->string('satuan');
            $table->integer('stok_awal')->default(0);
            $table->string('plant')->nullable();
            $table->string('status_product'); // Add this line
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}