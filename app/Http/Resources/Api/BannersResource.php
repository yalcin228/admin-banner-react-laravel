<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BannersResource extends JsonResource
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
            'id'            => $this->id,
            'siteName'      => $this->sites?->name,
            'sitePlace'     => $this->siteCategory?->place,
            'siteADS'       => $this->ads,
            'sort'          => $this->sort,
            'status'        => $this->status,
            'datetime'      => $this->datetime
        ];
    }
}
