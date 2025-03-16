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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('customer_id', 36);
            $table->string('service_id', 36);
            $table->text('order_id');
            $table->string('booking_code', 20);
            $table->timestamp('booking_date');
            $table->decimal('total_price', total: 10, places: 2);
            $table->decimal('paid_amount', total: 10, places: 2)->nullable();
            $table->string('payment_status', 20)->nullable();
            $table->string('payment_type', 20)->nullable();
            $table->text('signature_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
