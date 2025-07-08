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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Country::class)
                ->constrained('countries')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Weapon::class)
                ->constrained('weapons')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->timestamps();
            $table->unique(['country_id', 'weapon_id'], 'unique_country_weapon_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
