<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function sign_up(Request $request){
        $first_name=$request->first_name;
        $last_name=$request->last_name;
        $email=$request->email;
        $phone=$request->phone;
        $password=$request->password;

        $validate=validator($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'password'=>'required|min:8'
        ]);

        if(!$validate){
            return response()->json([
                'status'=>422,
                'message'=>$validate->errors(),
            ]);
        }

        $user = new User();
        $user->first_name=$first_name;
        $user->last_name=$last_name;
        $user->email=$email;
        $user->phone=$phone;
        $user->password=Hash::make($password);

        $user->save();

        if($user->save()){
            return response()->json([
                'status'=>200,
                'message'=>'Usuário criado',
            ]);
        }
        return response()->json([
            'status'=>400,
            'message'=>'Usuário não cadastrado',
        ]);
    }

    public function autentication(){

    }
}
