<?php

namespace App\Http\Controllers;

use App\Http\Resources\SensorResource;
use App\Http\Resources\SensorWithDataResource;
use App\Models\Datapoint;
use App\Models\Sensor;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SensorController extends Controller
{
    /**
     * All sensors.
     *
     * Returns all sensors in the database.
     * <br>
     * 🔑 `API_KEY` header required.
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
     * Create a new sensor.
     *
     * Create a new sensor with the provided data.
     * <br>
     * 🔑 `API_KEY` header required.
     */
    public function store(Request $request)
    {
        /*
            This feels so hacky
            I'm not sure if this is the best way to handle validation errors
            Actually, I'm pretty sure it's not

            I'm probably just doing it wrong
         */
        try {
            $request->validate([
                'station_id' => 'required',
                'name' => 'required',
                'type' => 'required',
                'unit' => 'required',
            ]);

            $station = Station::where('id', $request->station_id)->first();
            if (!$station) return response()->json(['error' => 'ERR_STATION_NOT_FOUND', 'message' => 'Station not found'], 404);

            $sensor = Sensor::create($request->only(['station_id', 'name', 'type', 'unit', 'depth']));
            return response()->json([
                'message' => 'SENSOR_CREATED',
                'data' => new SensorResource($sensor)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'ERR_EXCEPTION',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Specified sensor.
     *
     * Returns the sensor with the specified ID.
     * <br>
     * 🔑 `API_KEY` header required.
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
     *
     * Returns the most recent data from a sensor.
     * <br>
     * 🔑 `API_KEY` header required.
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
     *
     * Returns the data between two timestamps.
     * <br>
     * 🔑 `API_KEY` header required.
     *
     * ---
     *
     * URL Parameters:
     * - start: The start date of the range. Format: YYYY-MM-DD
     * - end: The end date of the range. Format: YYYY-MM-DD
     *
     * @param Request $request
     * @param string $id
     * @return SensorWithDataResource
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

    /**
     * Store data for a sensor or multiple sensors.
     *
     * Store data for a sensors with their specified IDs. Supports an object or an array of objects.
     * <br>
     * 🔑 `API_KEY` header required.
     */
    public function storeData(Request $request)
    {
        $data = $request->all();

        // PHP is weird, why does is_array return true for an object? I don't get it...
        if (array_keys($data) === array_keys(array_values($data))) {
            foreach ($data as $datapoint) {
                $request->validate([
                    'sensor_id' => 'required',
                    'value' => 'required',
                ]);

                Datapoint::create([
                    'sensor_id' => $datapoint['sensor_id'],
                    'value' => $datapoint['value'],
                    'timestamp' => $request->timestamp ?? now(),
                ]);
            }
        } else {
            Datapoint::create([
                'sensor_id' => $data['sensor_id'],
                'value' => $data['value'],
                'timestamp' => $request->timestamp ?? now(),
            ]);
        }

        return response()->json(['message' => 'DATA_STORED'], 201);
    }
}
