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
        Schema::dropIfExists('package_transports');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the table if needed, but since we're removing it, maybe leave empty or recreate
        // For simplicity, leave as is
    }
};
