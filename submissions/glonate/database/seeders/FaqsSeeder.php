<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqsSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        Faq::factory(10)->create();
    }
}
