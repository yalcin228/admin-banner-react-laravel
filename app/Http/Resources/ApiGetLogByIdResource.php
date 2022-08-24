<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiGetLogByIdResource extends JsonResource
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
            'info' => $this->info,
            'action' => $this->action,
            'ip' => $this->ip,
            'module' => $this->module,
            'status' => $this->status,
            'user' => ApiUserLogResource::make($this->admin)
        ];
    }
}
