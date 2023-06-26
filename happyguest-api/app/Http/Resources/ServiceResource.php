<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * The resource format.
     *
     * @var string
     */
    public static string $format = 'default';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        switch (self::$format) {
            case 'simple':
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'type' => $this->type,
                    'schedule' => $this->schedule,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'nameEN' => $this->nameEN,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'type' => $this->type,
                    'schedule' => $this->schedule,
                    'occupation' => $this->occupation,
                    'location' => $this->location,
                    'limit' => $this->limit,
                    'description' => $this->description,
                    'descriptionEN' => $this->descriptionEN,
                    'items' => ItemResource::collection($this->whenLoaded('items')),
                    'menu_url' => $this->menu_url,
                    'created_at' => $this->created_at->format('d/m/Y'),
                    'updated_at' => $this->updated_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
