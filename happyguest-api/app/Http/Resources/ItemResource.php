<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
                    'nameEN' => $this->nameEN,
                    'type' => $this->type,
                    'category' => $this->category,
                    'stock' => $this->stock,
                    'price' => $this->price,
                    'active' => $this->active,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'nameEN' => $this->nameEN,
                    'price' => $this->price,
                    'type' => $this->type,
                    'category' => $this->category,
                    'stock' => $this->stock,
                    'active' => $this->active,
                    'created_at' => $this->created_at->format('d/m/Y'),
                    'updated_at' => $this->updated_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
