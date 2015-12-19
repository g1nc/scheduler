<?php

use Illuminate\Database\Seeder;

class CourierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courier = factory(App\Courier::class, 10)->create();
    }
}
