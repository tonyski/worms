<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'special_id' => $this->special_id,
            'owner_id' => $this->owner_id,
            'color' => $this->color,
            'province' => $this->province,
            'city' => $this->city,
            'area' => $this->area,
            'description' => $this->description,
            'is_public' => $this->is_public,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // relations
            'users' => UserResource::collection($this->whenLoaded('users')),
            'applications' => UserResource::collection($this->whenLoaded('applications')),
            'games' => GameResource::collection($this->whenLoaded('games')),
        ];
    }
}
