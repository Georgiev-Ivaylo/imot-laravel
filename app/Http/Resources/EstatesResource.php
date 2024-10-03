<?php

namespace App\Http\Resources;

use App\Models\Estate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Number;

class EstatesResource extends JsonResource
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
            'price' => Number::currency($this->price, $this->currency_code),
            'region' => $this->region,
            'city' => $this->city,
            'village' => $this->village,
            'district' => $this->district,
            'type' => $this->type,
            'construction_type' => $this->construction_type,
            'land_size' => $this->land_size + Estate::UNSIGNED_SMALLINT,
            'building_size' => $this->building_size,
            'rooms' => $this->rooms,
            'bathrooms' => $this->bathrooms,
            'floors' => $this->floors,
            'floor_number' => $this->floor_number,
            'description' => $this->description,
            'construction_date' => Carbon::parse($this->construction_date)->toDateTimeString(),
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
            'author' => new PublicUserResource($this->whenLoaded('author')),
        ];
    }
}
