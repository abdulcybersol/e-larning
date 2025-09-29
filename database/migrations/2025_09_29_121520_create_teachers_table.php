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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('teaching_experience')->nullable();
            $table->boolean('online_teaching_experience')->default(false);
            $table->string('fluent_languages')->nullable();
            $table->integer('availability_hours_per_week')->nullable();
            $table->string('expected_class_time')->nullable();
            $table->string('position_applying_for')->nullable();
            $table->text('about')->nullable();
            $table->string('resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
