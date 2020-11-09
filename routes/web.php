<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::match(['get', 'post'], 'login', 'AuthController@frontLogin')->name('login');

Route::group([ 'middleware' => 'role:admin','prefix'=>'admin'],function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    //news section
    Route::match(['get', 'post'],'news/add', 'Admin\NewsController@addNews')->name('admin.news-add');
    Route::match(['get', 'post'],'news/edit/{news}', 'Admin\NewsController@edit')->name('admin.news-edit');
    Route::get('news', 'Admin\NewsController@index')->name('admin.news');
    Route::get('news\del\{news}', 'Admin\NewsController@del')->name('admin.news-del');

    //user section
    Route::get('users', 'Admin\UserController@index')->name('admin.users');
    Route::post('users/verify', 'Admin\UserController@verify')->name('admin.user-verify');
    Route::get('donors','Admin\UserController@donors')->name('admin.donors');
    Route::match(['get', 'post'],'users/add', 'Admin\User@addUser')->name('admin.user-add');
    Route::match(['get', 'post'],'users/edit/{user}', 'Admin\UserController@edit')->name('admin.user-edit');
  
    Route::get('user\del\{user}', 'Admin\UserController@del')->name('admin.user-del');
    
});

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
