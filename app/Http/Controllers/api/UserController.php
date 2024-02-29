<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function sign_up(Request $request){
        $first_name=$request->first_name;
        $last_name=$request->last_name;
        $email=$request->email;
        $phone=$request->phone;
        $password=Hash::make($request->password);

        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'password'=>'required|min:8'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'message'=>$validator->errors(),
            ],422);
        }
        $email_exits = User::where('email',$email)->first();

        if($email_exits){
            return response()->json([
                'status'=>422,
                'message'=>'Email já existe',
            ],422);
        }

        $user = new User();
        $user->first_name=$first_name;
        $user->last_name=$last_name;
        $user->email=$email;
        $user->phone=$phone;
        $user->password=$password;

        $user->save();

        if($user->save()){
            return response()->json([
                'status'=>200,
                'message'=>'Usuário criado',
            ],200);
        }
        return response()->json([
            'status'=>400,
            'message'=>'Usuário não cadastrado',
        ],400);
    }

    public function autentication(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|min:8'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'message'=>$validator->errors(),
            ],422);
        }

        $credentials=$request->only(['email','password']);

        if(!$token=auth()->attempt($credentials)){
            return response()->json([
                'status'=>400,
                'message'=>'Email/Senha inválidos',
            ],400);
        }
        
        if($request->email==="admin@gmail.com"){
            return response()->json([
                'status'=>200,
                'token'=>$token,
                'user'=>Auth::user(),
                'user_admin'=>'sim'
            ],200);
        }

        return response()->json([
            'status'=>200,
            'token'=>$token,
            'user'=>Auth::user(),
            'user_admin'=>'nao'
        ],200);
    }
}
