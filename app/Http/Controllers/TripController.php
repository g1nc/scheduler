<?php

namespace App\Http\Controllers;

use App\Courier;
use App\Trip;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TripController extends Controller
{
    public function getIndex(Request $request)
    {
        $trips = Trip::with('region')->with('courier')->get();

        if ($request->has('from')) {
            $trips = $trips->filter(function($trip) use ($request) {
                $from = Carbon::createFromFormat('d.m.Y', $request->get('from'));
                $trip_start = Carbon::createFromFormat('Y-m-d', $trip->start);
                return $from->lte($trip_start);
            });
        }
        if ($request->has('till')) {
            $trips = $trips->filter(function($trip) use ($request) {
                $till = Carbon::createFromFormat('d.m.Y', $request->get('till'));
                $trip_end = Carbon::createFromFormat('Y-m-d', $trip->end);
                return $till->gte($trip_end);
            });
        }

        return view('trips.index', compact('trips'));
    }

    public function getCreate()
    {
        $couriers = Courier::all();
        $regions = Region::all();

        return view('trips.create', compact('couriers', 'regions'));
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'start' => 'required'
        ]);

        $courier = Courier::find($request->get('courier_id'));
        $region = Region::find($request->get('region_id'));
        $start_date = Carbon::createFromFormat('d.m.Y', $request->get('start'));
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
            return $request->ajax() ? 'Поездка успешно добавлена' : redirect()->to('/');
        }
        else {
            return $request->ajax() ? 'В указанный период уже есть поездки' : redirect()->back()->withInput();
        }
    }
}
