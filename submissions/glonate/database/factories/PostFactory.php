<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PostFactory extends Factory
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
            'user_id' => rand(1,10),
            'title' => $name,
            'slug' => str_slug($name),
            'post_content' => $po,
            'feature_image' => null,
            'type' => 'post', //'post', 'page'
            'status' => 1,
            'show_in_header_menu' => 0,
            'show_in_footer_menu' => 0
        ];
    }
}
