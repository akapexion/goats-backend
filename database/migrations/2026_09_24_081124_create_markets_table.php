<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('address');
            $table->string('city', 100)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();   // for Google Maps / OpenStreetMap
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('open_days', 50)->nullable();      // e.g. "Sat,Sun"
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};
