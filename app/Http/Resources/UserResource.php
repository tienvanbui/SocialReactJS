<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'avatar' => $this->avatar,
            'email' => $this->email,
            'name' => $this->name,
            'us_created_at' => !empty($this->created_at) ? Carbon::parse($this->created_at)->format('Y-m-d') : null,
            'us_updated_at' => !empty($this->updated_at) ? Carbon::parse($this->updated_at)->format('Y-m-d') : null,
        ];
    }
}
