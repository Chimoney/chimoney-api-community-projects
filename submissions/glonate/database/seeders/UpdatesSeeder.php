<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Update;

class UpdatesSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        Update::factory(10)->create();
    }
}
