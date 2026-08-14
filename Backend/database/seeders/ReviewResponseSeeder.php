<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\ReviewResponses;
use Illuminate\Database\Seeder;

class ReviewResponseSeeder extends Seeder
{
    public function run(): void
    {
        Review::query()->with('store')->each(fn (Review $review) => ReviewResponses::factory()->create([
            'review_id' => $review->id,
            'store_owner_id' => $review->store->user_id,
        ]));
    }
}
