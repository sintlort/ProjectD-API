<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'=>$this->id,
            'nama_user'=>$this->nama_user,
            'tgl_lahir'=>$this->tgl_lahir,
            'gender'=>$this->gender,
            'alamat'=>$this->alamat,
            'email'=>$this->email,
            'telp'=>$this->telp,
            'project'=>$this->project,
        ];
    }
}
