<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CodeResource extends JsonResource
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
                    'code' => $this->code,
                    'rooms' => $this->rooms,
                    'used' => $this->used,
                    'entry_date' => $this->entry_date->format('d/m/Y'),
                    'exit_date' => $this->exit_date->format('d/m/Y'),
                    'checked_out' => $this->checkout ? $this->checkout->validated : null,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'code' => $this->code,
                    'rooms' => $this->rooms,
                    'used' => $this->used,
                    'entry_date' => $this->entry_date->format('d/m/Y'),
                    'exit_date' => $this->exit_date->format('d/m/Y'),
                    'checked_out' => $this->checkout ? $this->checkout->validated : null,
                    'created_at' => $this->created_at->format('d/m/Y H:i'),
                    'updated_at' => $this->updated_at->format('d/m/Y H:i'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
