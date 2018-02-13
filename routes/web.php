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

// Route::get('/', function () {
//     return view('welcome');
// });
//

//
//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/','PostController@index');
Auth::routes();
// Route::get('/home',['as' => 'home', 'uses' => 'PostController@index']);
Route::get('/home', 'PostController@index')->name('home');
//authentication


// Route::controllers([
//     'auth' => 'Auth\AuthController',
//     'password' => 'Auth\PasswordController',
// ]);

// Route::group(['middleware' => ['web'], 'namespace'=>'App\Http\Controllers'], function () {
//      Route::auth();
// });

// Route::get('/login',[
//     'uses' => 'Auth\AuthController@login',
//     'as'   => 'login'
// ]);
//

// Route::get('/login',[
//     'uses' => 'Auth\AuthController@login',
//     'as'   => 'login'
// ]);

// Route::get('auth/logout',[
//     'uses' => 'Auth\AuthController@logout',
//     'as'   => 'logout'
// ]);
Route::resource('auth', 'Auth\AuthController');
// Route::get('auth/logout','UserController@logout');

// Route::resource('auth', 'Auth\AuthController');
// Route::resource('password', 'Auth\PasswordController');
// Route::resource('password', 'Auth\PasswordController');
//Will probably use
// Route::middleware(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//         // Uses first & second Middleware
//     });
//
//     Route::get('user/profile', function () {
//         // Uses first & second Middleware
//     });
// });

// check for logged in user
Route::group(['middleware' => ['auth']], function()
{
    //show new post form
    Route::get('new-post','PostController@create');
    // save new post
    Route::post('new-post','PostController@store');
    // edit post form
    Route::get('edit/{slug}','PostController@edit');
    // update post
    Route::post('update','PostController@update');
    // delete post
    Route::get('delete/{id}','PostController@destroy');
    // display user's all posts
    Route::get('my-all-posts','UserController@user_posts_all');
    // display user's drafts
    Route::get('my-drafts','UserController@user_posts_draft');
    // add comment
    Route::post('comment/add','CommentController@store');
    // delete comment
    Route::post('comment/delete/{id}','CommentController@distroy');

});
//users profile
Route::get('user/{id}','UserController@profile')->where('id', '[0-9]+');
// // display list of posts
Route::get('user/{id}/posts','UserController@user_posts')->where('id', '[0-9]+');
// // display single post
Route::get('/{slug}',['as' => 'post', 'uses' => 'PostController@show']);
