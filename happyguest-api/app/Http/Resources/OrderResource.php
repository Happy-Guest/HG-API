<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
                    'user' => $this->user->name,
                    'service' => [
                        'id' => $this->service->id,
                        'name' => $this->service->name,
                        'type' => $this->service->type,
                    ],
                    'room' => $this->room,
                    'time' => $this->time->format('d/m/Y H:i'),
                    'status' => $this->status,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'user' => [
                        'id' => $this->user->id,
                        'name' => $this->user->name,
                    ],
                    'service' => [
                        'id' => $this->service->id,
                        'name' => $this->service->name,
                        'type' => $this->service->type,
                    ],
                    'items' => $this->orderItems->map(function ($orderItem) {
                        return [
                            'id' => $orderItem->item->id,
                            'name' => $orderItem->item->name,
                            'nameEN' => $orderItem->item->nameEN,
                            'type' => $orderItem->item->type,
                            'category' => $orderItem->item->category,
                            'quantity' => $orderItem->quantity,
                            'price' => $orderItem->item->price,
                        ];
                    }),
                    'room' => $this->room,
                    'time' => $this->time->format('d/m/Y H:i'),
                    'status' => $this->status,
                    'price' => $this->price,
                    'comment' => $this->comment,
                    'created_at' => $this->created_at->format('d/m/Y'),
                    'updated_at' => $this->updated_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
