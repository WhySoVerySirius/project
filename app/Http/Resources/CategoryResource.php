<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'category_id' => $this->id,
            'category_title' => $this->title,
            'deleted_at' => $this->deleted_at ?? '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}
