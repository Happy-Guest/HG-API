<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'website' => $this->website,
            'capacity' => $this->capacity,
            'policies' => $this->policies,
            'access' => $this->access,
            'comodities' => $this->comodities,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
