<?php

namespace App\Models\api;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarWash extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'appointment',
        'date',
        'hour',
        'minute',
        'confirmation'
    ];

    protected $casts = [
        'date' => 'datetime:d/m/Y',
    ];

    public function user(){
       return $this->belongsTo(User::class,'user_id');
    }
}
