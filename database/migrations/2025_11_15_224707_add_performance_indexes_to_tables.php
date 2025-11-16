<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add indexes for better query performance
     */
    public function up(): void
    {
        // ✅ Reservations table indexes
        Schema::table('reservations', function (Blueprint $table) {
            $table->index('user_id'); // For user reservations lookup
            $table->index('doctor_id'); // For doctor schedule lookup
            $table->index('treatment_id'); // For treatment statistics
            $table->index('status'); // For status filtering
            $table->index('reservation_date'); // For date filtering
            $table->index(['doctor_id', 'reservation_date', 'reservation_time']); // For slot availability check
            $table->index(['user_id', 'status']); // For user reservation history
            $table->index(['status', 'reservation_date']); // For admin dashboard stats
        });

        // ✅ Feedbacks table indexes
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->index('is_visible'); // For landing page feedbacks
            $table->index('overall_rating'); // For rating filters
            $table->index(['is_visible', 'created_at']); // For latest visible feedbacks
        });

        // ✅ Treatments table indexes
        Schema::table('treatments', function (Blueprint $table) {
            $table->index('created_at'); // For latest treatments
        });

        // ✅ Schedules table indexes
        Schema::table('schedules', function (Blueprint $table) {
            $table->index(['doctor_id', 'day_of_week', 'status']); // For schedule availability lookup
        });

        // ✅ Doctors table indexes
        Schema::table('doctors', function (Blueprint $table) {
            $table->index('status'); // For active doctors lookup
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['doctor_id']);
            $table->dropIndex(['treatment_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['reservation_date']);
            $table->dropIndex(['doctor_id', 'reservation_date', 'reservation_time']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['status', 'reservation_date']);
        });

        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropIndex(['is_visible']);
            $table->dropIndex(['overall_rating']);
            $table->dropIndex(['is_visible', 'created_at']);
        });

        Schema::table('treatments', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex(['doctor_id', 'day_of_week', 'status']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
