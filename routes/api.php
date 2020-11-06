<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('forgetpassword', 'AuthController@forgot');
    Route::post('reset', 'AuthController@reset');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('changepassword','AuthController@changePassword');
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
