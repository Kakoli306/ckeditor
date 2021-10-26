<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;


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

Route::post('app/create_tag', 'App\Http\Controllers\AdminController@addTag');
Route::get('app/get_tags', 'App\Http\Controllers\AdminController@getTag');
Route::post('app/edit_tag', 'App\Http\Controllers\AdminController@editTag');
Route::post('app/delete_tag', 'App\Http\Controllers\AdminController@deleteTag');
Route::post('app/upload', 'App\Http\Controllers\AdminController@upload');
Route::post('app/delete_image', 'App\Http\Controllers\AdminController@deleteImage');
Route::post('app/create_category', 'App\Http\Controllers\AdminController@addCategory');
Route::get('app/get_category', 'App\Http\Controllers\AdminController@getCategory');
Route::post('app/edit_category', 'App\Http\Controllers\AdminController@editCategory');



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::any('{slug}', function(){
        return view('welcome');
  });
