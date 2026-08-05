<?php

use App\Models\Reservation;
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
        Schema::create('pickup_verification_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Reservation::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'verified_by')->constrained()->restrictOnDelete();
            $table->string('method');
            $table->string('status');
            $table->string('failure_reason')->nullable();
            $table->timestamp('attempted_at');
            $table->ipAddress()->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_verification_attempts');
    }
};
