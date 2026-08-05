<?php

use App\Enums\ReservationItemStatus;
use App\Models\Product;
use App\Models\Reservation;
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
        Schema::create('reservation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Reservation::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->restrictOnDelete();
            $table->string('product_name', 150);
            $table->decimal('unit_price', 12, 2);
            $table->integer('requested_quantity')->default(1);
            $table->integer('accepted_quantity')->default(0);
            $table->string('status')->default(ReservationItemStatus::PENDING->value);
            $table->text('rejection_reason')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            $table->index('reservation_id');
            $table->index('product_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_items');
    }
};
