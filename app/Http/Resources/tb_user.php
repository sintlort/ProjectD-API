<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class tb_user extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username'=>$this->username,
            'nama_user' => $this->nama_user,
            'tgl_lahir'=>$this->tgl_lahir,
            'gender'=>$this->gender,
            'alamat'=>$this->alamat,
            'email' => $this->email,
            'telp'=>$this->telp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public static $wrap = 'user';
}
