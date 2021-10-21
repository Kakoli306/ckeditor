<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::any('{slug}', function(){
        return view('welcome');
  });
