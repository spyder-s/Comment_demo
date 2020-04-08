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
//    return view('posts.index');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index')->name('index');
Route::get('/posts-create', 'PostController@create')->name('posts-create');
Route::post('posts-store', 'PostController@store')->name('posts-store');
Route::get('posts-show/{id}', 'PostController@show')->name('posts-show');

Route::post('comments-store', 'CommentController@store')->name('comments-store');

Route::get('contact-list', 'ChatController@contact_list')->name('contact-list');
Route::get('message-send/{id}', 'ChatController@index')->name('message-send');
//Route::post('message-send', 'ChatController@index')->name('message-send');
Route::post('chat-message', 'ChatController@chat_message')->name('chat-message');



//Route::get('/', 'PostController@index')->name('/');
//Route::get('posts.index', 'PostController@index')->name('posts.index');
//Route::get('posts.show', 'PostController@show')->name('posts.show');
//Route::get('/posts.create', 'PostController@create')->name('posts.create');
//Route::post('posts.store', 'PostController@store')->name('posts.store');
//Route::get('posts.show/{id}', 'PostController@show')->name('posts.show');
//Route::post('comments.store', 'CommentController@store')->name('comments.store');
