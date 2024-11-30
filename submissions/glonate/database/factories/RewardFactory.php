<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class RewardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1,10),
            //'campaign_id' => , prefilled by seeder
            //'amount' =>  '80.00',
            'description' => fake()->realText(100),
            'estimated_delivery' => now(),
            'quantity' => rand(10,20),
            'equity_share_percent' => null
        ];
    }
}
