<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                    'email' => $this->email,
                    'role' => $this->role,
                    'blocked' => $this->blocked,
                    'photo_url' => $this->photo_url,
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'birth_date' => $this->birth_date ? $this->birth_date->format('d/m/Y') : null,
                    'role' => $this->role,
                    'blocked' => $this->blocked,
                    'photo_url' => $this->photo_url,
                    'last_review' => $this->last_review ? $this->last_review->format('d/m/Y') : null,
                    'created_at' => $this->created_at->format('d/m/Y'),
                    'updated_at' => $this->updated_at->format('d/m/Y'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
