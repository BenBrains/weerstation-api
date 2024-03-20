<?php

namespace App\Http\Controllers;

use App\Http\Resources\StationResource;
use App\Models\Station;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * All stations.
     */
    public function index()
    {
        $data = Station::get();
        if (empty($data)) return response()->json(['error' => 'ERR_NOT_FOUND', 'message' => 'Specified resource not found'], 404);

        return StationResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Create a new station.
     *
     * Create a new station with the provided data. Returns:
     * - 201 Created on success
     * - 409 Conflict if the station already exists.
     * ```json
     * {
     *      "name": "string",
     *      "location": "string",
     *      "hardware_version": "string",
     *      "software_version": "string",
     *      "lat": 0,
     *      "lon": 0
     * }
     */
    public function store(Request $request)
    {
        $body = $request->json()->all();

        $requiredKeys = ['name', 'location', 'hardware_version', 'software_version'];
        $missingKeys = array_diff_key(array_flip($requiredKeys), $body);

        if (!empty($missingKeys)) return response()->json(['error' => 'ERR_BAD_REQUEST', 'message' => 'Missing required fields'], 400);
//
        $stationExists = Station::where('name', $body['name'])->first();
        if (!empty($stationExists)) return response()->json(['error' => 'ERR_CONFLICT', 'message' => 'Station already exists'], 409);

        try {
            $station = Station::create($body);
            return response()->json([
                'message' => 'STATION_CREATED',
                'data' => new StationResource($station)
            ], 201);
        } catch (\Exception $e) {
            echo $e;
            return response()->json(['error' => 'ERR_INTERNAL_SERVER', 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Specific station.
     */
    public function show(string $id)
    {
        $data = Station::find($id);
        if (empty($data)) return response()->json(['error' => 'ERR_NOT_FOUND', 'message' => 'Specified resource not found'], 404);
        return new StationResource($data);
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
}
