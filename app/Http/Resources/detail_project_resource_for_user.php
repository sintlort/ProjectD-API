<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class detail_project_resource_for_user extends JsonResource
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
            'id_project'=>$this->id_project,
            'user'=>$this->user,
        ];
    }
}
