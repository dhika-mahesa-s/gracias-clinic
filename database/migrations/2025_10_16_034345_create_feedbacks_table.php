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
      Schema::create('feedbacks', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('phone')->nullable();
    $table->string('service_type')->nullable();
    $table->integer('staff_rating');
    $table->integer('professional_rating');
    $table->integer('result_rating');
    $table->integer('return_rating');
    $table->integer('overall_rating');
    $table->text('message')->nullable();
    $table->boolean('is_approved')->default(false);
    $table->boolean('is_hidden')->default(false);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
