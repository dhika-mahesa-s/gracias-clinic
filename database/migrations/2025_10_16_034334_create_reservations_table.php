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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('treatment_id')->constrained('treatments')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->decimal('total_price', 12, 2)->default(0);
            $table->enum('status', ['pending','confirmed','completed','cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
