<?php

namespace App\Http\Controllers;

use App\Http\Resources\detail_project_resource;
use App\Http\Resources\project_collector;
use App\Http\Resources\projectResource;
use App\Http\Resources\user_collecting;
use App\Http\Resources\UserResource;
use App\Models\tb_detail_project;
use App\Models\tb_project;
use App\Models\tb_user;
use Validator;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class androidAPIController extends Controller
{

    public function loginAPI(Request $data_login)
    {
        $val = tb_user::where('username',$data_login->username)->first();
        if($val != null){
            if (Hash::check($data_login->password, $val->password)){
                $user = new user_collecting(tb_user::where('username',$data_login->username)->first());
                $returndata = array('status'=>"200",'message'=>'success','user'=>$user);
                return response()->json($returndata,200);
            }else{
                $returndata = array('status'=>"200",'message'=>'password is wrong');
            };
        }else{
            $returndata = array('status'=>"200",'message'=>'cannot find the user');
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
                $returndata = array('status'=>"200",'message'=>'success','user'=>$user);
                return response()->json($returndata,200);
            } else {
                $returnerrordata = array('status'=>"200",'message'=>'username has been used');
                return response()->json($returnerrordata, 200);
            }
    }
    public function getProject() {
        $alldata = tb_project::all();
        //$project = array('status'=>'200','message'=>'success','project'=>project_collector::collection(tb_project::all()));
        return response()->json($alldata, 200);
    }

    public function addProject(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_project'=>'required',
            'start_project'=>'required',
            'end_project'=>'required',
            'desc_project'=>'required',
            'status_project'=>'required',
            'no_hp'=>'required',
            'max_orang'=>'required',
            'username'=>'required',
            'encoded_image'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $imageName = Str::random(10).'.'.'png';
        File::put(public_path().'/project_images/'.$imageName, base64_decode($request->encoded_image));
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
            'project_image'=>$imageName,
        ]);
        $project = array('status'=>'200','message'=>'success','project'=>$data);
        return response()->json($project,200);
    }


    public function selectaProject(Request $request){

        if(tb_project::find($request->id)!=null){
            $projectData = new project_collector(tb_project::where('id',$request->id)->first());
            $returnData = array('status'=>"200",'message'=>'success','data'=>$projectData);
            return response()->json($returnData,200);
        }else{
            $returnData = array('status'=>'401','message'=>'project not found');
            return response()->json($returnData,401);
        }
    }

    public function updateProject(Request $request){
        $project = tb_project::where('id',$request->id)->first();
        $project->nama_project=$request->nama_project;
        $project->start_project=$request->start_project;
        $project->end_project=$request->end_project;
        $project->desc_project=$request->desc_project;
        $project->no_hp=$request->no_hp;
        $project->max_orang=$request->max_orang;
        $project->save();
        $newDataProject = tb_project::where('id',$request->id)->first();
        $returnData = array('status'=>"200",'message'=>'data updated','data'=>$newDataProject);
        return response()->json($returnData,200);
    }

    public function stopProject(Request $request){
        $dataProject = tb_project::where('id',$request->id)->first();
        $dataProject->status_project=0;
        $dataProject->save();
        $newDataProject = new project_collector(tb_project::where('id',$request->id)->first());
        $returnData = array('status'=>"200",'message'=>'project stopped','data'=>$newDataProject);
        return response()->json($returnData,200);
    }

    public function deleteProject(Request $request){
        $deleteProject = tb_project::find($request->id);
        $deleteProject->delete();
        $returnData = array('status'=>"200",'message'=>'project deleted');
        return response()->json($returnData,200);
    }

    public function dataProject(Request $request)
    {
        $data = projectResource::collection(tb_project::with('assignment')->where('id',$request->id)->get());
        $historyProject = detail_project_resource::collection(tb_detail_project::with('project')->where('id_project',$request->id)->get());
        $testdata = tb_detail_project::with('project')->where('id_project',$request->id)->get();
        return response()->json(["data"=>$data],200);
    }

    public function getMyProject(Request $request)
    {
        $myProject = UserResource::collection(tb_user::with('project')->where('id',$request->id)->get());
        return response()->json(['status'=>'200','data'=>$myProject],200);
    }

    public function joinProject(Request $request)
    {
        $joinProject = tb_detail_project::create([
            'id_project'=>$request->id_project,
            'id_user'=>$request->id_user,
            'nama'=>$request->nama,
            'noHp'=>$request->noHp,
        ]);
        return response()->json(['status'=>'200','message'=>'Berhasil']);
    }

    public function detailUserInAProject(Request $request){
        $detailProject = tb_detail_project::where('id_project',$request->id_project)->get();

        foreach ($detailProject as $key => $detail) {
            $user = tb_user::find($detail->id_user);
            $data[$key] = $user;
        }
        return response()->json($data, 200);
    }

    public function detailUserHistoryProject(Request $request){

        $detailProject = tb_detail_project::where('id_user',$request->id_user)->get();

        foreach ($detailProject as $key => $detail) {
            $project = tb_project::find($detail->id_project);
            $data[$key] = $project;
        }

        return response()->json($data, 200);

    }

}
