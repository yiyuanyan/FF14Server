<?php

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
/* -----------后台管理路由start----------- */
Route::get('/login','\App\Http\Controllers\LoginController@index');
Route::post('/login/login','LoginController@login');
//抓取数据
Route::get('/admin/getbossitems/{name}','AdminController@getbossitems');


Route::get('/admin',"AdminController@index");
Route::get('/admin/boss',"AdminController@boss");
Route::get('/admin/gooditems',"AdminController@gooditems");
/* -----------后台管理路由end----------- */
//获取副本
//http://yiyuanyan.eicp.net:8001/api/getdungeon
Route::get('/api/getdungeonall','\App\Http\Controllers\ApiController@getdungeonall');
Route::get('/api/getdungeon/{id}','\App\Http\Controllers\ApiController@getdungeon');
//通过名称获取boss信息
//http://yiyuanyan.eicp.net:8001/api/getbossinfo/%E5%8D%A2%E5%8A%A0%E7%89%B9
Route::get('/api/getbossinfo/{name}','\App\Http\Controllers\ApiController@getbossinfo');
//获取单个物品信息
Route::get('/api/getgooditems/{id}','\App\Http\Controllers\ApiController@getgooditems');
//获取副本下所有BOSS信息
Route::get('api/getdungeonboss/{name}','\App\Http\Controllers\ApiController@getdungeonboss');
//通过BOSS名称获取BOSS的掉落物品
Route::get('api/getbossitems/{name}','\App\Http\Controllers\ApiController@getbossitems');
//列表
Route::get('/posts','\App\Http\Controllers\PostsController@index');
//详情
Route::get('/posts/{$id}','\App\Http\Controllers\PostsController@show');
//创建
Route::get('/posts/create','\App\Http\Controllers\PostsController@create');
//
Route::post('/posts','\App\Http\Controllers\PostsController@store');
//编辑
//Route::get('/posts/{$id}/edit','\App\Http\Controllers\PostsController@edit');
//Route::put('/posts/{$id}','\App\Http\Controllers\PostsController@update');
//删除
Route::get('posts/delete', '\App\Http\Controllers\PostsController@delete');
