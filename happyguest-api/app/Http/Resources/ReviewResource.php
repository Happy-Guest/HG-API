<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
                    'user' => $this->user_id ? $this->user->name : null,
                    'stars' => $this->stars,
                    'autorize' => $this->autorize,
                    'shared' => $this->shared,
                    'created_at' => $this->created_at->format('d/m/Y'),
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'user' => $this->user_id ? [
                        'id' => $this->user->id,
                        'name' => $this->user->name,
                    ] : null,
                    'stars' => $this->stars,
                    'comment' => $this->comment,
                    'autorize' => $this->autorize,
                    'shared' => $this->shared,
                    'created_at' => $this->created_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
