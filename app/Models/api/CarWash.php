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
        'confirmation'
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
}
