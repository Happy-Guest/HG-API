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
                    'userId' => $this->user_id ?: null,
                    'title' => $this->title,
                    'local' => $this->local,
                    'status' => $this->status,
                    'created_at' => $this->created_at->format('d/m/Y'),
                ];
            case 'detailed':
                return [
                    'id' => $this->id,
                    'user' => $this->user_id ? [
                        'id' => $this->user->id,
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                    ] : null,
                    'title' => $this->title,
                    'date' => $this->date->format('d/m/Y'),
                    'local' => $this->local,
                    'status' => $this->status,
                    'comment' => $this->comment,
                    'files' => $this->files->map(function ($file) {
                        return [
                            'id' => $file->id,
                            'filename' => $file->filename,
                        ];
                    }),
                    'response' => $this->response,
                    'created_at' => $this->created_at->format('d/m/Y H:i'),
                    'updated_at' => $this->updated_at->format('d/m/Y H:i'),
                ];
            default:
                return parent::toArray($request);
        }
    }
}
