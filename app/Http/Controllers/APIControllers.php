<?php


namespace App\Http\Controllers;


use App\Models\tb_user;
use GuzzleHttp\Psr7\Request;
use Illuminate\Routing\Controller as BaseController;

class APIControllers extends Controller
{
    public function apilogin(Request $request){
        $val = tb_user::where('nama',$request->nama)->first();
        return $val;
    }

    public function test(){
        $val = tb_user::where('nama','dewa')->first();
        return $val;
    }
}
