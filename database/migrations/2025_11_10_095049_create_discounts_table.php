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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama event diskon (e.g., "11.11 Sale", "Black Friday")
            $table->text('description')->nullable(); // Deskripsi diskon
            $table->enum('type', ['percentage', 'fixed'])->default('percentage'); // Tipe diskon
            $table->decimal('value', 10, 2); // Nilai diskon (% atau nominal)
            $table->dateTime('start_date'); // Tanggal mulai
            $table->dateTime('end_date'); // Tanggal berakhir
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });

        // Pivot table untuk treatment yang mendapat diskon
        Schema::create('discount_treatment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_id')->constrained()->onDelete('cascade');
            $table->foreignId('treatment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_treatment');
        Schema::dropIfExists('discounts');
    }
};
