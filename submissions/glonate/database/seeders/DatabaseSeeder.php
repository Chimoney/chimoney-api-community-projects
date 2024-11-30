<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(CampaignsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(FaqsSeeder::class);
        $this->call(OptionsSeeder::class);
        $this->call(PaymentsSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(RewardsSeeder::class);
        $this->call(UpdatesSeeder::class);
    }
}
