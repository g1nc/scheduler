<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CourierTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(TripTableSeeder::class);

        Model::reguard();
    }
}
