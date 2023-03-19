<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'post' => new PostResource($this->whenLoaded('post')),
            'published_at' => $this->published_at->format('Y-m-d'),
            $this->mergeWhen($request->user()?->can('comments:read'), [
                'is_visible' => $this->is_visible,
                'updated_at' => $this->updated_at->format('Y-m-d'),
                'created_at' => $this->created_at->format('Y-m-d'),
            ]),
        ];
    }
}
