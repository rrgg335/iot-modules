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
        Schema::create('module_measurements', function (Blueprint $table) {
            $table->id();
			$table->foreignId('module_id');
			$table->foreignId('measurement_type_id');
			$table->foreignId('measurement_unit_id');
            $table->string('min_value')->nullable();
            $table->string('max_value')->nullable();
            $table->string('optimal_value')->nullable();
            $table->string('current_value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_measurements');
    }
};
