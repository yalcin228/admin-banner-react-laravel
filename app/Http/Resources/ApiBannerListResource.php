<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiBannerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ads' => $this->ads,
            'site' => ApiBannerSiteResource::make($this->sites),
            'category' => ApiBannerSiteCategoryResource::make($this->siteCategory),
            'status' => $this->status,
            'sort' => $this->sort
        ];
    }
}
