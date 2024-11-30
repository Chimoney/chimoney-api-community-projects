<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        Post::factory()->create([
            'title' => 'Cookie and Privacy Policy', 
            'slug' => 'cookie-and-privacy-policy', 
            'post_content' => '<p>1.&nbsp;Cookies help us deliver services, By browsing our website, you agree to our use of cookies.</p> <p>2. We are not selling your personal data</p> <p>3. Your Personal Data will store to our server securely</p> <p>4. We are saving cookies to your browser to retrieve and taste your experience later.</p>',
            'type' => 'page',
            'show_in_footer_menu' => 1
        ]);
        
        Post::factory(10)->create();
    }
}
