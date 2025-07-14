<?php

use App\Models\Category;
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
            $table->foreignIdFor(Category::class)->constrained('categories');
            $table->integer('base_price')->default(0);
            $table->integer('quantity')->default(1);

            $table->integer('discount_percentage')->default(0);
            $table->string('image_path')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
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
