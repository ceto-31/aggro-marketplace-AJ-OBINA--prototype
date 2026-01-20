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
        Schema::create('rice_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('rice_variety');
            $table->decimal('price_per_kg', 10, 2);
            $table->integer('quantity_available');
            $table->string('unit')->default('kg');
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('harvest_date')->nullable();
            $table->enum('quality_grade', ['premium', 'standard', 'economy'])->default('standard');
            $table->string('image_path')->nullable();
            $table->enum('status', ['active', 'sold_out', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rice_listings');
    }
};
