<?php

use Illuminate\Database\Seeder;
use App\Region;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = ['Санкт-Петербург', 'Уфа', 'Нижний Новгород', 'Владимир', 'Кострома', 'Екатеринбург', 'Ковров', 'Воронеж', 'Самара', 'Астрахань'];
        foreach($regions as $region) {
            Region::create(array(
                'name' => $region,
                'long' => rand(1, 15)
            ));
        }
    }
}

