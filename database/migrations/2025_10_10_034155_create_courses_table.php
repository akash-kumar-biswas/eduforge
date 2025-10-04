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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('instructor_id')->index()->nullable();
            $table->enum('type', ['free', 'paid'])->default('paid');
            $table->integer('duration')->nullable()->comment('duration in hours');;
            $table->decimal('price', 10, 2)->default(0.00);
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->string('image')->nullable();
            $table->text('content_url')->nullable();
            $table->integer('status')->default(0)->comment('0 pending, 1 inactive, 2 active');
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
