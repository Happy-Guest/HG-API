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
                    'price' => $this->price,
                    'type' => $this->type,
                    'category' => $this->category,
                    'amount_stock' => $this->amount_stock,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'price' => $this->price,
                    'type' => $this->type,
                    'category' => $this->category,
                    'amount_stock' => $this->amount_stock,
                    'created_at' => $this->created_at->format('d/m/Y'),
                    'updated_at' => $this->updated_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
