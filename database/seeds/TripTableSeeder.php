<?php

use Illuminate\Database\Seeder;
use App\Trip;
use App\Region;
use App\Courier;
use Carbon\Carbon;

class TripTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1,40) as $i) {
            $date = Carbon::create(2015, 5, 1, 0, 0, 0);
            $courier = Courier::find(rand(1,10));
            $region = Region::find(rand(1,10));
            $start_date = $date->addDays(rand(1, 210));
            $end_date = Carbon::create($start_date->year, $start_date->month, $start_date->day + $region->long, 0, 0, 0);

            $trips = Trip::with('courier')->where('courier_id', $courier->id)->get();
            $filtered = $trips->filter(function($trip) use ($start_date, $end_date) {
                $trip_start = Carbon::createFromFormat('Y-m-d', $trip->start)->startOfDay();
                $trip_end = Carbon::createFromFormat('Y-m-d', $trip->end)->startOfDay();

                $trip_in_range = $trip_start->between($start_date, $end_date) || $trip_end->between($start_date, $end_date);
                $trip_over_range = $start_date->lte($trip_start) && $end_date->gte($trip_end);

                return $trip_in_range || $trip_over_range;
            });

            if ($filtered->isEmpty()) {
                Trip::create(array(
                    'courier_id' => $courier->id,
                    'region_id' => $region->id,
                    'start' => $start_date->format('Y-m-d'),
                    'end' => $end_date->format('Y-m-d')
                ));
            }

        }
    }
}
