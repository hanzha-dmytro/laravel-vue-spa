<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return [
            'id' => $this->id,
            'name' =>  $this->name,
            'email' =>  $this->email,
            'is_active' => $this->is_active,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'role' => new RoleResource($this->whenLoaded('role')),
            $this->mergeWhen($request->user()?->can('users:read'), [
                'created_at' => $this->created_at->format('Y-m-d'),
                'updated_at' => $this->updated_at->format('Y-m-d'),
            ]),
        ];
    }
}
