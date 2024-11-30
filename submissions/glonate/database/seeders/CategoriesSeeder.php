<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        for ($i=1; $i < 9; $i++) { 
            Category::factory()->create([
                'image' => $i.'.jpg'
            ]);
        }
    }
}
