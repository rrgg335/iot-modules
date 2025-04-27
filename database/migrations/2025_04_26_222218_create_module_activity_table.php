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
        Schema::create('module_activity', function (Blueprint $table) {
            $table->id();
			$table->foreignId('module_id');
            $table->string('activity')->nullable();
            $table->enum('activity_type',['success','info','warning','danger'])->default('info');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_activity');
    }
};
