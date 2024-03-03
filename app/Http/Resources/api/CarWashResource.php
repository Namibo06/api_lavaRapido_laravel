<?php

namespace App\Http\Resources\api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarWashResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //$fullName=$this->user()->first_name." ".$this->user()->last_name;
        $date=Carbon::createFromFormat('Y-m-d H:i:s',$this->date)->format('d/m/Y');
        $fullHour=$date." ".$this->hour.":".$this->minute;
        $hourMinute=$this->hour.":".$this->minute;
        return [
            'user'=>[
                'id_user'=>$this->user->id,
                'first_name'=>$this->user->first_name,
                'last_name'=>$this->user->last_name,
                'fullName'=>$this->user->first_name." ".$this->user->last_name,
                'phone'=>$this->user->phone,
                'email'=>$this->user->email
            ],
            'horario'=>[
                'cod'=>$this->id,
                'fullHour'=>$fullHour,
                'hourMinute'=>$hourMinute,
                'date'=>$date,
                'hour'=>$this->hour,
                'minute'=>$this->minute,
                'confirmado'=>$this->confirmation

            ],
        ];
    }
}
