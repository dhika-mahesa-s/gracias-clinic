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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('service_type')->nullable();
            $table->text('message')->nullable();
            $table->tinyInteger('staff_rating')->unsigned()->default(0)->comment('skala 1-5');
            $table->tinyInteger('professional_rating')->unsigned()->default(0)->comment('skala 1-5');
            $table->tinyInteger('result_rating')->unsigned()->default(0)->comment('skala 1-5');
            $table->tinyInteger('return_rating')->unsigned()->default(0)->comment('skala 1-5');
            $table->tinyInteger('overall_rating')->unsigned()->default(0)->comment('skala 1-5');
            $table->tinyInteger('rating')->unsigned()->nullable()->comment('skala 1-5 - untuk backward compatibility');
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_visible')->default(true);
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
