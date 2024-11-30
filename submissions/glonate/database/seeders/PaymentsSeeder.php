<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Payment,Campaign};

class PaymentsSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        for ($i=0; $i < 30; $i++) {
            $camp_id = rand(1,30);
            Payment::factory()->create([
                'campaign_id' => $camp_id,
                'amount' => rand(100,300),
            ]);
            Campaign::findOrFail($camp_id)->updateTotalNow();
        }
    }
}
