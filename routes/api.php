<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;



Route::group([


    ['middleware'=>'admin-api']

    // 'middleware' => 'api',
    // 'prefix'=>'auth'


], function () {


    Route::post('/AdminRegister' , [AdminController::class , 'AdminRegister']);
    Route::post('/AdminLogin', [AdminController::class , 'AdminLogin']);
    Route::post('/Admin/Logout', [AdminController::class , 'Logout']);
    //Route::post('/refresh', [AdminController::class , 'refresh']);
    Route::post('Admin/me', [AdminController::class , 'me']);


});



Route::group([['middleware'=>'user-api']], function () {


    Route::post('/UserRegister' , [UserController::class , 'UserRegister']);
    Route::post('/UserLogin', [UserController::class , 'Userlogin']);
    Route::post('/Userlogout', [UserController::class , 'Userlogout']);
    //Route::post('/Userrefresh', [UserController::class , 'Userrefresh']);
    Route::post('User/me', [UserController::class , 'me']);


});