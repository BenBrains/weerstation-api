<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SensorWithDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'station_id' => $this->station_id,
            'name' => $this->name,
            'depth' => $this->depth,
            'type' => $this->type,
            'unit' => $this->unit,
            'datapoints' => DatapointResource::collection($this->datapoints)
        ];
    }
}
