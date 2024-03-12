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
     *
     * @bodyParam name string required The name of the station.
     * @bodyParam location string required The location of the station.
     * @bodyParam hardware_version string The hardware version of the station.
     * @bodyParam software_version string The software version of the station.
     * @bodyParam lat float required The latitude of the station.
     * @bodyParam lon float required The longitude of the station.
     *
     * @param Request $request The HTTP request.
     * @return JsonResponse The HTTP response.
     */
    public function store(Request $request)
    {
        $body = $request->json()->all();
        return response()->json(['message' => 'Data received', 'data' => $body]);
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
