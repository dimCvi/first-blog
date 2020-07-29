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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->prefix('admin')->name('admin.')->namespace('Admin')->group(function() 
{
    $c = 'IndexController@';
    
    Route::get('', $c . 'index')->name('index.index');
    
    Route::prefix('users')->name('users.')->group(function() {
        $c = 'UsersController@';
        
        Route::get('', $c . 'index')->name('index');
    });
});
