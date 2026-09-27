<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Extra details only for users with the Farmer role
        Schema::create('farmer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('market_id')->nullable()->constrained()->nullOnDelete();
            $table->string('stall_name', 100);
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->string('operating_days', 50)->nullable();        // e.g. "Sat,Sun"
            $table->time('pickup_start_time')->nullable();
            $table->time('pickup_end_time')->nullable();
            $table->unsignedSmallInteger('cutoff_hours')->default(12); // orders close X hours before pickup

            // Admin approves farmers before they can list products
            $table->enum('approval_status', ['pending', 'approved', 'suspended'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmer_profiles');
    }
};
