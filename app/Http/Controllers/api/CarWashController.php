<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\CarWashResource;
use App\Models\api\CarWash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarWashController extends Controller
{
    public function avaliable_schedules(){
        //lógica,mostrar para o barbeiro horarios marcados,e para os clientes remover este horário,tipo deixa a data,mas tira a hora e minuto
        $horarios = CarWashResource::collection(CarWash::all());
        return response()->json([
            'status'=>200,
            'horarios_preenchidos'=>$horarios
        ]);
    }

    public function make_an_appointment(Request $request){
        $user_id=$request->user_id;
        $date_without_format=$request->date;
        $date=Carbon::createFromFormat('d m Y',$date_without_format)->format('Y-m-d');
        $hour=$request->hour;
        $minute=$request->minute;

        $validator=Validator::make($request->all(),[
            'date'=>'required',
            'hour'=>'required',
            'minute'=>'required'
        ]);

        if(!$validator){
            return response()->json([
                'status'=>422,
                'message'=>$validator->errors()
            ],422);
        }

        $date_exist=CarWash::select('date')->where('date',$date)->first();

        $hour_exist=CarWash::select('hour')->where('hour',$hour)->first();

        $minute_exist=CarWash::select('minute')->where('minute',$minute)->first();

        if($date_exist && $hour_exist && $minute_exist){
            return response()->json([
                'status'=>422,
                'message'=>'Horário já está marcado,tente outro',
                'date'=>$date_exist,
                'hour'=>$hour_exist,
                'minute'=>$minute_exist
            ],422);
        }

        $make_an_appointment=new CarWash();
        $make_an_appointment->user_id=$user_id;
        $make_an_appointment->date=$date;
        $make_an_appointment->hour=$hour;
        $make_an_appointment->minute=$minute;
        $make_an_appointment->save();

        if($make_an_appointment->save()){
            return response()->json([
                'status'=>200,
                'message'=>'Horário marcado'
            ],200);
        }
        return response()->json([
            'status'=>400,
            'message'=>'Não foi possível marcar neste horário'
        ],200);
    }

    public function time_confirmation(Request $request){
        $id=$request->id;
        $confirmation=$request->confirmation;

        $update_confirmation=CarWash::where('id',$id)->update([
            'confirmation'=>$confirmation
        ]);

        if($update_confirmation){
            return response()->json([
                'status'=>200,
                'message'=>'Horário confirmado'
            ],200);
        }
        return response()->json([
            'status'=>400,
            'message'=>'Não foi possível confirmar horário'
        ],200);
    }
}
