<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteCategoryResource extends JsonResource
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
            'id' => $this->id,
            'site_id' => $this->site_id,
            'site_name' => $this?->sites?->name,
            'image' => asset('storage/site-category/'.$this->image),
            'place' => $this->place,
            'type'  => $this->type,
            'status' => $this->status
        ];
    }
}
