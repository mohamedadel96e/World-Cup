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
        Schema::create('bombings', function (Blueprint $table) {
            $table->id();
            // Attacker country
            $table->foreignId('attacker_country_id')->constrained('countries')->cascadeOnDelete();
            // Targeted country
            $table->foreignId('target_country_id')->constrained('countries')->cascadeOnDelete();
            $table->foreignId('weapon_id')->constrained('weapons')->cascadeOnDelete();
            $table->integer('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bombings');
    }
};
