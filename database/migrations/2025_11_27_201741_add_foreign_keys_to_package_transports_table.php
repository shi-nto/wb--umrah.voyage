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
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('transport_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_transports', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropForeign(['transport_id']);
            $table->dropColumn(['package_id', 'transport_id']);
        });
    }
};
