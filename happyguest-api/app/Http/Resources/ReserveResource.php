<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReserveResource extends JsonResource
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
                    'user' => $this->user->name ?? $this->user_name,
                    'service' => [
                        'id' => $this->service->id,
                        'name' => $this->service->name,
                        'type' => $this->service->type,
                    ],
                    'nr_people' => $this->nr_people,
                    'time' => $this->time->format('d/m/Y H:i'),
                    'status' => $this->status,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'user' => [
                        'id' => $this->user->id ?? null,
                        'name' => $this->user->name ?? $this->user_name,
                    ],
                    'nr_people' => $this->nr_people,
                    'time' => $this->time->format('d/m/Y H:i'),
                    'status' => $this->status,
                    'service' => [
                        'id' => $this->service->id,
                        'name' => $this->service->name,
                        'type' => $this->service->type,
                    ],
                    'comment' => $this->comment,
                    'created_at' => $this->created_at->format('d/m/Y'),
                    'updated_at' => $this->updated_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
