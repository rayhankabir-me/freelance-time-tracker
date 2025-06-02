<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id"                => $this->id,
            "title"             => $this->title,
            "description"       => $this->description,
            "status"            => $this->status,
            "deadline"          => $this->deadline,
            "client"            => $this->client,
        ];
    }
}
