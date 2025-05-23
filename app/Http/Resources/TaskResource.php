<?php

namespace App\Http\Resources;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'user' =>new UserResource($this->whenLoaded('user')),
            'status' => new StatusResource($this->whenLoaded('status')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
