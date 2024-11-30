<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->sentence(4);

        $po = '';
        foreach (fake()->paragraphs(10) as $pa) {$po .= "<p>{$pa}</p>";}

        return [
            'user_id' => rand(1, 6),
            'category_id' => rand(1,8),
            'title' => $name,
            'slug' => str_slug($name),
            'short_description' => fake()->realText(100), 
            'description' => $po,
            'campaign_owner_commission' => '80.00',
            'goal' => rand('900','1200'),
            'min_amount' => null,
            'max_amount' => null,
            'recommended_amount' => null,
            'amount_prefilled' => '10,20,30,40',
            'end_method' => 'end_date' ,//goal_achieved
            'views' => null,
            'video' => null,
            'feature_image' => rand(1,7).'.jpg',
            'status'  => rand(0,1),       //0:pending,1:approve,2:blocked
            'country_id' => rand(1,20),
            'address' => ' 4919 Arbor Court\nCasper, WY 82601 ',

            'is_funded'  => rand(0,1), //0:pending,1:approve,2:blocked
            'start_date' => now(),
            'end_date' => now()->addDays(5),
            'total_funded_last_upated_at' => now(),
        ];

    }
}
