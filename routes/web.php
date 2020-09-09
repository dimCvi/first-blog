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

        Route::post('datatable', $c . 'datatable')->name('datatable');

        Route::get('add', $c . 'add')->name('add');
        Route::post('add', $c . 'insert')->name('insert');

        Route::get('edit/{user}', $c . 'edit')->name('edit');
        Route::post('edit/{user}', $c . 'update')->name('update');

        Route::get('profile', $c . 'profile')->name('profile');
        Route::post('profile', $c . 'updateProfile')->name('profile');
        
        Route::get('change-password', $c . 'changePasswordForm')->name('change_password');
        Route::post('change-password', $c . 'changePassword')->name('change_password');

        Route::post('ban/{users}', $c . 'ban')->name('ban');
    });
});
