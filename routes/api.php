<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware(['checkkey'])->group(function(){

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');
        Route::post('forgetpassword', 'AuthController@forgot');
        Route::post('reset', 'AuthController@reset');
        Route::Post('social','SocialController@user');
    
        Route::group([
          'middleware' => 'auth:api'
        ], function() {
            Route::get('changepassword','AuthController@changePassword');
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'AuthController@user');
            Route::match(['get', 'post'], 'info', 'UserController@info');
        
        });
    });
    Route::group([ 'auth:api' => '','prefix'=>'user'],function (){
        Route::match(['get', 'post'], 'memo', 'UserController@memo');

        
        Route::get('bloodreq','UserController@bloodRequest');
        Route::post('addbloodreq','UserController@addBloodRequest');
        Route::match(['get', 'post'], 'req/{id}', 'UserController@getBloodRequest');
    });

    
    Route::post('donars','GeneralController@GetDonar');
    Route::post('covidwinner','GeneralController@GetWinner');
    
// });

