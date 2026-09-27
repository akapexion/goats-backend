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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('farmer_profile_id')->constrained()->restrictOnDelete();
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->enum('status', ['placed', 'accepted', 'ready_for_pickup', 'completed', 'cancelled'])->default('placed');
            $table->decimal('total_amount', 10, 2)->default(0);  // paid in person at pickup
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index(['farmer_profile_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
