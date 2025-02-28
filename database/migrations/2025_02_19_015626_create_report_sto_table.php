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
    Schema::create('report_sto', function (Blueprint $table) {
      $table->id(); // Primary key
      $table->date('issued_date'); // Issued date of the report

      // Foreign key to the inventory table
      $table->string('inventory_id');

      // Foreign key to the users table for the preparer
      $table->foreignId('prepared_by')
        ->constrained('users')
        ->onDelete('cascade');

      // Foreign key to the users table for the checker (nullable)
      $table->foreignId('checked_by')
        ->nullable()
        ->constrained('users')
        ->onDelete('cascade');

      $table->string('status'); // Status of the report
      $table->integer('qty_per_box'); // Quantity per box
      $table->integer('qty_box'); // Number of boxes
      $table->integer('total'); // Total quantity
      $table->integer('qty_per_box_2')->nullable(); // Quantity per box (optional)
      $table->integer('qty_box_2')->nullable(); // Number of boxes (optional)
      $table->integer('total_2')->nullable(); // Total quantity (optional)
      $table->integer('grand_total'); // Grand total quantity
      $table->string('detail_lokasi')->nullable(); // Detail location (optional)
      $table->string('customer')->nullable(); // Customer (optional)
      $table->timestamps(); // Timestamps for created_at and updated_at
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('report_sto'); // Drop the report_sto table
  }
};