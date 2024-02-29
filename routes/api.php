<?php

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\CarWashController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1/user')->group(function(){
    Route::post('/sign_up',[UserController::class,'sign_up']);
    Route::post('/autentication',[UserController::class,'autentication']);
});

Route::prefix('v1/car_wash')->group(function(){
    //horarios disponiveis
    Route::get('/avaliable_schedules',[CarWashController::class,'avaliable_schedules']);
    //marcar horario
    Route::post('/make_an_appointment',[CarWashController::class,'make_an_appointment']);
    //confirmar horario
    Route::post('/time_confirmation',[CarWashController::class,'time_confirmation']);
});
