<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
            'phone' => $this->phone,
            'emergency_phone' => $this->emergency_phone,
            'introduction' => $this->introduction,
            'last_login_at' => $this->last_login_at,
            // relations
            'pivot' => $this->whenLoaded('pivot'),
        ];
    }
}
