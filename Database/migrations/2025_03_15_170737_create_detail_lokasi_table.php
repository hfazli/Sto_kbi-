<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailLokasiTable extends Migration
{
    public function up()
    {
        Schema::create('detail_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('category');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_lokasi');
    }
}