<?php

use App\Models\Country;
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
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Country::class)->constrained('countries');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['Infantry', 'Tank', 'Artillery', 'Plane', 'Navy']);
            $table->integer('attack_power')->default(0);
            $table->integer('defense_power')->default(0);
            $table->integer('speed')->default(0);
            $table->integer('range')->default(0);
            $table->integer('base_price')->default(0);
            $table->integer('maintenance_cost')->default(0);
            $table->integer('production_time')->default(0);
            $table->string('image_path')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};
