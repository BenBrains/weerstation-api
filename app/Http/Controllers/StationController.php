<?php

namespace App\Http\Controllers;

use App\Http\Resources\StationResource;
use App\Models\Station;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

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
        /*
            This feels so hacky
            I'm not sure if this is the best way to handle validation errors
            Actually, I'm pretty sure it's not

            I'm probably just doing it wrong
         */
        try {
            $request->validate([
                'name' => 'required',
                'location' => 'required',
                'hardware_version' => 'required',
                'software_version' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'ERR_VALIDATION',
                'message' => $e->errors(),
            ], $e->status);
        }

        $station = Station::where('name', $request->name)->first();
        if ($station) return response()->json(['error' => 'ERR_CONFLICT', 'message' => 'Station already exists'], 409);

        $station = Station::create($request->only(['name', 'location', 'hardware_version', 'software_version', 'lat', 'lon']));
        return response()->json([
            'message' => 'STATION_CREATED',
            'data' => new StationResource($station)
        ], 201);
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
