<?php

namespace App\Http\Controllers;

use App\Http\Resources\project_collector;
use App\Http\Resources\user_collecting;
use App\Models\tb_project;
use App\Models\tb_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class androidAPIController extends Controller
{

    public function loginAPI(Request $data_login)
    {
        $val = tb_user::where('username',$data_login->username)->first();
        if($val != null){
            if (Hash::check($data_login->password, $val->password)){
                $user = new user_collecting(tb_user::where('username',$data_login->username)->first());
                $returndata = array('error'=>"false",'message'=>'success','user'=>$user);
                return response()->json($returndata,200);
            }else{
                return response()->json("data not found",500);
            };
        }else{
          return response()->json("data not found",500);
        };
    }

    public function registerAPI(Request $data_register)
    {
            $check = tb_user::where('username',$data_register->username)->first();
            if ($check==null){
                tb_user::create([
                    'username'=>$data_register->username,
                    'password'=>Hash::make($data_register->password),
                    'nama_user'=>$data_register->nama_user,
                    'tgl_lahir'=>$data_register->tgl_lahir,
                    'gender'=>$data_register->gender,
                    'alamat'=>$data_register->alamat,
                    'email'=>$data_register->email,
                    'telp'=>$data_register->telp,
                ]);
                $user = new user_collecting(tb_user::where('username',$data_register->username)->first());
                $returndata = array('error'=>"false",'message'=>'success','user'=>$user);
                return response()->json($returndata,200);
            } else {
                $returnerrordata = array('error'=>"true",'message'=>'username has been used');
                return response()->json($returnerrordata, 200);
            }
    }

    public function addProject(Request $request){
        $user_id = tb_user::where('username',$request->username)->first();
        $data = tb_project::create([
            'nama_project'=>$request->nama_project,
            'start_project'=>$request->start_project,
            'end_project'=>$request->end_project,
            'desc_project'=>$request->desc_project,
            'status_project'=>$request->status_project,
            'no_hp'=>$request->no_hp,
            'max_orang'=>$request->max_orang,
            'user_id'=>$user_id->id,
        ]);
        $project = array('status'=>'200','message'=>'success','project'=>new project_collector($data));
        return response()->json($project,200);
    }

    public function getProject() {
        $alldata = project_collector::collection(tb_project::all());
        $project = array('status'=>'200','message'=>'success','project'=>project_collector::collection(tb_project::all()));
        return response()->json($project, 200);
    }
}
