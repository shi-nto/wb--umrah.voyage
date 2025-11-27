<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['event_id']);
            $table->dropColumn(['hotel_id', 'event_id', 'reste']);
            $table->renameColumn('tPrix', 'totalPrix');
            $table->renameColumn('paye', 'montantPaye');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('totalPrix', 'tPrix');
            $table->renameColumn('montantPaye', 'paye');
            $table->decimal('reste', 10, 2)->nullable();
            $table->foreignId('hotel_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};
