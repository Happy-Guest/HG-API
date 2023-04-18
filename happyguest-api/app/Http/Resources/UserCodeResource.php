<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCodeResource extends JsonResource
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
                    'code_id' => $this->code_id,
                    'user_id' => $this->user_id,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'code' => $this->code,
                    'user' => $this->user,
                ];
            default:
                return parent::toArray($request);
        }
    }
}
