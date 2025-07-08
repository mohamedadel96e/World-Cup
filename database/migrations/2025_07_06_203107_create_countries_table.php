<?php

use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class)->constrained('teams');
            $table->string('name')->unique();
            $table->string('code', 3)->unique();
            $table->string('currency_name');
            $table->string('currency_code', 3)->unique();
            $table->string('logo')->nullable();
            $table->string('flag')->nullable();
            $table->string('currency_symbol', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
