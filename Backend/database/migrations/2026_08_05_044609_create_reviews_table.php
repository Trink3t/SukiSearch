<?php

use App\Models\Reservation;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Reservation::class)->unique()->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'customer_id')->constrained()->restrictOnDelete();
            $table->foreignIdFor(Store::class)->constrained()->restrictOnDelete();
            $table->smallInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
