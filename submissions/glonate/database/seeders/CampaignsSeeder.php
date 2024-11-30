<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;

class CampaignsSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        Campaign::factory(30)->create();
    }
}
