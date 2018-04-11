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

//Route::group(['middleware'=>['web']],function () {
    Route::get('/', 'Home\HomeController@index');
    Route::get('a/{id}', 'Home\HomeController@article');
    Route::get('category/{id}', 'Home\HomeController@articleList');


Route::any('admin/login', 'Admin\LoginController@login');//接收get访问和post提交
    Route::get('admin/code', 'Admin\LoginController@code');

    Route::get('admin/crypt', 'Admin\LoginController@crypt');

//});

Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function () {
    Route::get('', 'IndexController@Index')-> name('admin');
    Route::get('info', 'IndexController@Info');
    Route::get('logout', 'IndexController@logout');
    Route::any('resetpass','IndexController@resetPass');

    Route::resource('category','CategoryController');
    Route::post('category/changeorder','CategoryController@changeOrder');

    Route::resource('article','ArticleController');
    Route::any('upload','AdminBaseController@upload');//图片上传放到基类

    Route::resource('links','LinksController');
    Route::post('links/changeorder','LinksController@changeOrder');

    Route::resource('navs','NavsController');
    Route::post('navs/changeorder','NavsController@changeOrder');

    Route::resource('web_config','WebConfigController');
    Route::post('web_config/changeorder','WebConfigController@changeOrder');
    Route::post('web_config/change_content','WebConfigController@changeContent');
});