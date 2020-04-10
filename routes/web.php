<?php

use App\Model\Post;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('index');

Route::get('/posts-create', 'PostController@create')->name('posts-create');
Route::post('posts-store', 'PostController@store')->name('posts-store');
Route::get('posts-show/{id}', 'PostController@show')->name('posts-show');
Route::post('comments-store', 'CommentController@store')->name('comments-store');

Route::get('/chat', 'HomeController@chat')->name('chat');
Route::get('/message/{id}', 'HomeController@getMessage')->name('message');
Route::post('message', 'HomeController@sendMessage');

Route::post('create-group', 'HomeController@create_group')->name('create-group');
//Route::get('user-list', 'HomeController@member_list')->name('user-list');
Route::get('member-list/{id}', 'HomeController@member_list')->name('member-list');
Route::post('add-member', 'HomeController@add_member')->name('add-member');

