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
        Schema::table('relationships', function (Blueprint $table) {
            $table->renameColumn('from_pilgrim_id', 'pilgrim_a_id');
            $table->renameColumn('to_pilgrim_id', 'pilgrim_b_id');
        });
    }

    public function down(): void
    {
        Schema::table('relationships', function (Blueprint $table) {
            $table->renameColumn('pilgrim_a_id', 'from_pilgrim_id');
            $table->renameColumn('pilgrim_b_id', 'to_pilgrim_id');
        });
    }
};
