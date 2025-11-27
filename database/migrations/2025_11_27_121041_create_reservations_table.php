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
            $table->unsignedBigInteger('pilgrim_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('event_id');
            $table->decimal('tPrix', 10, 2);
            $table->decimal('paye', 10, 2)->default(0);
            $table->decimal('reste', 10, 2);
            $table->boolean('selectionne')->default(false);
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
