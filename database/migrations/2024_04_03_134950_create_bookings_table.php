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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->unsignedBigInteger('room_id')->nullable(false);
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('started_at')->nullable(false);
            $table->timestamp('finished_at')->nullable(false);
            $table->integer('days')->nullable(false);
            $table->integer('price')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
