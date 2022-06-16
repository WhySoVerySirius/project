<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public static $wrap = 'news';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        // dd($this);
        return [
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'id' => $this->id,
            'uuid' => $this->uuid,
        ];
    }
}
