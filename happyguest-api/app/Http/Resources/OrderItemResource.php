<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
                    'order' => $this->order_id,
                    'item' => $this->item_id,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'order' => $this->order,
                    'item' => $this->item,
                ];
            default:
                return parent::toArray($request);
        }
    }
}
