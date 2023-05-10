<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'remember_token' => $this->remember_token
        ];
    }
}
