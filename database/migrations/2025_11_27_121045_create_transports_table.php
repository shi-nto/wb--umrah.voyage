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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Flight, Bus, Train
            $table->string('provider'); // Airline, Bus company
            $table->string('departCity');
            $table->string('arriveCity');
            $table->date('departDate');
            $table->date('arriveDate');
            $table->string('status')->default('Pending'); // Confirmed, Pending, Cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
