<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(int $count = 30): void
    {
        $users = User::query()->get();

        if ($count === 0 || $users->isEmpty()) {
            return;
        }

        Notification::factory($count)
            ->sequence(fn (Sequence $sequence): array => [
                'user_id' => $users[$sequence->index % $users->count()]->id,
            ])
            ->create();
    }
}
