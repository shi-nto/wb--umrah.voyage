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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_pilgrim_id')->constrained('pilgrims')->onDelete('cascade');
            $table->foreignId('to_pilgrim_id')->constrained('pilgrims')->onDelete('cascade');
            $table->string('relationType'); // Husband, Wife, Father, Mother, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
