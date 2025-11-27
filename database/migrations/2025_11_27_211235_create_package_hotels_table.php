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
        if (!Schema::hasTable('package_hotels')) {
            Schema::create('package_hotels', function (Blueprint $table) {
                $table->id();
                $table->foreignId('package_id')->constrained()->onDelete('cascade');
                $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
                $table->string('city')->nullable();
                $table->integer('nights')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('package_hotels', function (Blueprint $table) {
                if (!Schema::hasColumn('package_hotels', 'package_id')) {
                    $table->foreignId('package_id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('package_hotels', 'hotel_id')) {
                    $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('package_hotels', 'city')) {
                    $table->string('city')->nullable();
                }
                if (!Schema::hasColumn('package_hotels', 'nights')) {
                    $table->integer('nights')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_hotels');
    }
};
