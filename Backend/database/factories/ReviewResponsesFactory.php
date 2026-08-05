<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\ReviewResponses;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReviewResponses>
 */
class ReviewResponsesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review_id' => Review::factory(), 'store_owner_id' => User::factory(), 'response' => 'Maraming salamat po sa inyong review!',
        ];
    }
}
