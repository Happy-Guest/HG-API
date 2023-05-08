<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
                    'title' => $this->title,
                    'status' => $this->status,
                    'room' => $this->room,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'user_id' => $this->user_id,
                    'title' => $this->title,
                    'status' => $this->status,
                    'comment' => $this->comment,
                    'room' => $this->room,
                    'created_at' => $this->created_at->format('Y/m/d H:i'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
