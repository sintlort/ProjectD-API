<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class project_collector extends JsonResource
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
            'id'=> $this->id,
            'nama_project'=>$this->nama_project,
            'start_project' => $this->start_project,
            'end_project'=>$this->end_project,
            'desc_project'=>$this->desc_project,
            'status_project'=>$this->status_project,
            'no_hp' => $this->no_hp,
            'max_orang'=>$this->max_orang,
            'user_id'=>$this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public static $wrap = 'project';
}
