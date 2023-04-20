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
            case 'code':
                return [
                    'id' => $this->id,
                    'code' => [
                        'id' => $this->code->id,
                        'code' => $this->code->code,
                        'rooms' => $this->code->rooms,
                        'used' => $this->code->used,
                    ],
                    'user_id' => $this->user_id,
                ];
            case 'user':
                return [
                    'id' => $this->id,
                    'code_id' => $this->code_id,
                    'user' => [
                        'id' => $this->user->id,
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'role' => $this->user->role,
                    ],
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
