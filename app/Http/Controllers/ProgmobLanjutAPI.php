<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;

class ProgmobLanjutAPI extends Controller
{
    public function addMahasiswa(Request $request){
        $data = mahasiswa::create([
            'nama'=>$request->nama,
            'nim'=>$request->nim,
            'alamat'=>$request->alamat,
            'gender'=>$request->gender,
        ]);
        return response()->json($data, 200);
    }

    public function showMahasiswa(Request $request){
        $data = mahasiswa::where('nama',$request->nama)->first();
        return response()->json($data,200);
    }

    public function showallMahasiswa(){
        $data = mahasiswa::all();
        return response()->json($data,200);
    }
}
