<?php

namespace App\Http\Controllers;

use App\Http\Resources\SensorResource;
use App\Http\Resources\SensorWithDataResource;
use App\Models\Datapoint;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SensorController extends Controller
{
    /**
     * All sensors.
     *
     * Returns all sensors in the database.
     */
    public function index()
    {
        $data = Sensor::all();
        return SensorResource::collection($data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Specified sensor.
     */
    public function show(string $id)
    {
        $sensorData = Sensor::find($id);
        return new SensorResource($sensorData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Recent data from a sensor.
     */
    public function recent(Request $request, string $id)
    {
        $amount = $request->query('amount');
        $unit = $request->query('unit');

        $sensor = Sensor::find($id);

        // This does not work and I don't know why...
//        $functionName = 'sub' . ucfirst($unit);
//        var_dump($functionName);
//        if (method_exists(Carbon::class, $functionName)) {
//            $sensor->datapoints = Datapoint::where('sensor_id', $id)
//                ->where('timestamp', '>', now()->$functionName($amount))
//                ->get();
//        } else {
//            echo 'Wat de fuq man';
//            $sensor->datapoints = Datapoint::where('sensor_id', $id)
//                ->where('timestamp', '>', now()->subMonth())
//                ->get();
//        }

//        There has to be a better way to do this...
        switch ($unit) {
            case 'minutes':
                $sensor->datapoints = Datapoint::where('sensor_id', $id)
                    ->where('timestamp', '>', now()->subMinutes($amount))
                    ->get();
                break;
            case 'hours':
                $sensor->datapoints = Datapoint::where('sensor_id', $id)
                    ->where('timestamp', '>', now()->subHours($amount))
                    ->get();
                break;
            case 'days':
                $sensor->datapoints = Datapoint::where('sensor_id', $id)
                    ->where('timestamp', '>', now()->subDays($amount))
                    ->get();
                break;
            case 'weeks':
                $sensor->datapoints = Datapoint::where('sensor_id', $id)
                    ->where('timestamp', '>', now()->subWeeks($amount))
                    ->get();
                break;
            case 'months':
                $sensor->datapoints = Datapoint::where('sensor_id', $id)
                    ->where('timestamp', '>', now()->subMonths($amount))
                    ->get();
                break;
            case 'years':
                $sensor->datapoints = Datapoint::where('sensor_id', $id)
                    ->where('timestamp', '>', now()->subYears($amount))
                    ->get();
                break;
            default:
                // Defaults to last week
                $sensor->datapoints = Datapoint::where('sensor_id', $id)
                    ->where('timestamp', '>', now()->subMonth())
                    ->get();
        }

        return new SensorWithDataResource($sensor);
    }

    /**
     * Data between two timestamps.
     */
    public function between(Request $request, string $id)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        if (!$start || !$end) {
            return response()->json(['error' => 'ERR_NO_PARAM', 'message' => 'Start and end parameters are required'], 400);
        }

        $sensor = Sensor::find($id);
        $sensor->datapoints = Datapoint::where('sensor_id', $id)
            ->where('timestamp', '>=', $start)
            ->where('timestamp', '<=', $end)
            ->get();

        return new SensorWithDataResource($sensor);
    }
}
