<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reward;
use App\Models\Campaign;

class RewardsSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $ids = Campaign::all()->pluck('id')->toArray();
        $amounts = [150,200,250];

        foreach ($ids as $key => $id) {

            for ($i=0; $i < 3; $i++) { 
                Reward::factory()->create([
                    'campaign_id' => $id,
                    'amount' =>  $amounts[$i],
                ]);
            }
        }
    }
}
