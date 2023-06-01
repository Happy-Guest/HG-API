<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
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
                    'code' => $this->code->code,
                    'validated' => $this->validated,
                    'created_at' => $this->created_at->format('d/m/Y'),
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'user' => [
                        'id' => $this->user->id,
                        'name' => $this->user->name,
                    ],
                    'code' => [
                        'code' => $this->code->code,
                        'rooms' => $this->code->rooms,
                        'entry_date' => $this->code->entry_date->format('d/m/Y'),
                        'expiration_date' => $this->code->expiration_date->format('d/m/Y'),
                    ],
                    'validated' => $this->validated,
                    'created_at' => $this->created_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
