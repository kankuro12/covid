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
Route::match(['get', 'post'], 'logout', 'AuthController@frontLogout')->name('logout');

Route::group([ 'middleware' => 'role:admin','prefix'=>'admin'],function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    //news section
    Route::match(['get', 'post'],'news/add', 'Admin\NewsController@addNews')->name('admin.news-add');
    Route::match(['get', 'post'],'news/edit/{news}', 'Admin\NewsController@edit')->name('admin.news-edit');
    Route::get('news', 'Admin\NewsController@index')->name('admin.news');
    Route::get('news\del\{news}', 'Admin\NewsController@del')->name('admin.news-del');

    //user section
    Route::get('users', 'Admin\UserController@index')->name('admin.users');
    Route::get('users/search/{phone}/{req_id}', 'Admin\UserController@search')->name('admin.user-search-phone');
    Route::post('users/verify', 'Admin\UserController@verify')->name('admin.user-verify');
    Route::get('donors','Admin\UserController@donors')->name('admin.donors');
    Route::get('show/{user}','Admin\UserController@show')->name('admin.user-show');
    
    Route::match(['get', 'post'],'users/edit/{user}', 'Admin\UserController@edit')->name('admin.user-edit');
    Route::match(['get', 'post'],'users/add', 'Admin\UserController@add')->name('admin.user-add');
  
    Route::post('req/{req}','Admin\UserController@updateReq')->name('admin.update-req');
    Route::get('user\del\{user}', 'Admin\UserController@del')->name('admin.user-del');
    
    //Request Section
    Route::get('requests', 'Admin\RequestController@index')->name('admin.requests');
    Route::get('exrequests', 'Admin\RequestController@expired')->name('admin.exrequests');
    Route::match(['get','post'],'requests/add', 'Admin\RequestController@add')->name('admin.request-add');
    Route::get('requests/edit/{req}', 'Admin\RequestController@edit')->name('admin.request-edit');
    Route::get('requests/del/{req}', 'Admin\RequestController@del')->name('admin.request-del');
    Route::get('requests/show/{req}', 'Admin\RequestController@show')->name('admin.request-show');
    Route::get('requests/complete/{req}/{user}', 'Admin\RequestController@complete')->name('admin.request-complete');
    Route::post('requests/verify', 'Admin\RequestController@verify')->name('admin.req-verify');

   
    //aboutus
    Route::match(['get','post'],'about', 'Admin\GeneralController@about')->name('admin.about');
    Route::match(['get','post'],'message', 'Admin\GeneralController@message')->name('admin.message');
    //donations
    Route::get('/donations','Admin\GeneralController@donations')->name('admin.donations');
});

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
