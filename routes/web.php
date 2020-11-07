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
    Route::match(['get', 'post'],'news/add', 'Admin\NewsController@addNews')->name('admin.news-add');
    Route::match(['get', 'post'],'news/edit/{news}', 'Admin\NewsController@edit')->name('admin.news-edit');
    Route::get('news', 'Admin\NewsController@index')->name('admin.news');
    Route::get('news\del\{news}', 'Admin\NewsController@del')->name('admin.news-del');
    
});

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
