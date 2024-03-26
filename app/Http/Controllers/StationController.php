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
     *
     * Returns a list of all stations.
     * <br>
     * 🔑 `API_KEY` header required.
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
     * Create a new station with the provided data.
     * <br>
     * 🔑 `API_KEY` header required.
     *
     * > _I have no idea why statuscode `200` is in this list. Just ignore this for now._
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
     *
     * Returns the specified station.
     * <br>
     * 🔑 `API_KEY` header required.
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
