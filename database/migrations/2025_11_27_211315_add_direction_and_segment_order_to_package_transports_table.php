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
        Schema::table('package_transports', function (Blueprint $table) {
            $table->string('direction')->nullable();
            $table->integer('segment_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_transports', function (Blueprint $table) {
            $table->dropColumn(['direction', 'segment_order']);
        });
    }
};
