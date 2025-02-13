<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWipsTable extends Migration
{
    public function up()
    {
        Schema::create('wips', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_id');
            $table->string('part_name');
            $table->string('part_number');
            $table->string('type_package');
            $table->integer('qty_per_package');
            $table->string('project');
            $table->string('customer');
            $table->string('location_rak');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wips');
    }
}