<?php

use App\Enums\ReservationStatus;
use App\Models\Store;
use App\Models\User;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->foreignIdFor(User::class, 'customer_id')->constrained()->restrictOnDelete();
            $table->foreignIdFor(Store::class)->constrained()->restrictOnDelete();
            $table->string('status')->default(ReservationStatus::PENDING->value);
            $table->timestamp('expires_at')->nullable();
            $table->string('pickup_code_hash')->nullable();
            $table->string('qr_token_hash')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->text('cancelled_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
