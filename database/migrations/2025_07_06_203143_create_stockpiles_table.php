<?php

use App\Models\Country;
use App\Models\Weapon;
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
        Schema::create('stockpiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Weapon::class)
                ->constrained('weapons')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockpiles');
    }
};
