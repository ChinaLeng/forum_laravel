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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/','Index\PagesController@root')->name('root');

//Auth::routes();
//上面一句等同下面
// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//用户个人中
//Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
//上面一句话等同下面三句
Route::get('/users/{user}', 'Index\UsersController@show')->name('users.show');
Route::get('/users/{user}/edit', 'Index\UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'Index\UsersController@update')->name('users.update');
//文章相关路由
Route::resource('topics', 'Index\TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'Index\TopicsController@show')->name('topics.show');
Route::resource('categories', 'Index\CategoriesController', ['only' => ['show']]);
Route::post('upload_image', 'Index\TopicsController@uploadImage')->name('topics.upload_image');//编辑器图片上传
Route::resource('replies', 'Index\RepliesController', ['only' => ['store', 'destroy']]);//留言
Route::resource('notifications', 'Index\NotificationsController', ['only' => ['index']]);//通知路由
Route::get('permission-denied', 'Index\PagesController@permissionDenied')->name('permission-denied');