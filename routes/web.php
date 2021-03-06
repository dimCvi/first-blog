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

Route::middleware('auth')->prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
    $c = 'IndexController@';
    
    Route::get('', $c . 'index')->name('index.index');
    
    Route::prefix('users')->name('users.')->group(function () {
        $c = 'UsersController@';
        
        Route::get('', $c . 'index')->name('index');
        Route::post('datatable', $c . 'datatable')->name('datatable');
        Route::get('add', $c . 'add')->name('add');
        Route::post('add', $c . 'insert')->name('insert');
        Route::get('edit/{entity}', $c . 'edit')->name('edit');
        Route::post('edit/{entity}', $c . 'update')->name('update');
        Route::get('profile', $c . 'profile')->name('profile');
        Route::post('profile', $c . 'updateProfile')->name('profile');
        Route::get('change-password', $c . 'changePasswordForm')->name('change_password');
        Route::post('change-password', $c . 'changePassword')->name('change_password');
        Route::post('ban/{entity}', $c . 'ban')->name('ban');
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        $c = 'PostController@';
        
        Route::get('', $c . 'index')->name('index');
        Route::post('datatable', $c . 'datatable')->name('datatable');
        Route::get('add', $c . 'add')->name('add');
        Route::post('add', $c . 'insert')->name('insert');
        Route::get('edit/{entity}', $c . 'edit')->name('edit');
        Route::post('edit/{entity}', $c . 'update')->name('update');
        Route::post('ban/{entity}', $c . 'ban')->name('ban');
        Route::post('change-featured/{entity}', $c . 'changeFeatured')->name('change_featured');
    });
    
    Route::prefix('categories')->name('categories.')->group(function () {
        $c = 'CategoriesController@';
        
        Route::get('', $c . 'index')->name('index');
        Route::post('datatable', $c . 'datatable')->name('datatable');
        Route::get('add', $c . 'add')->name('add');
        Route::post('add', $c . 'insert')->name('insert');
        Route::get('edit/{entity}', $c . 'edit')->name('edit');
        Route::post('edit/{entity}', $c . 'update')->name('update');
        Route::post('delete/{entity}', $c . 'delete')->name('delete');
        Route::post('changepriority/{entity}', $c . 'changepriority')->name('changepriority');
    });
    Route::prefix('sliders')->name('sliders.')->group(function () {
        $c = 'SliderController@';
        
        Route::get('', $c . 'index')->name('index');
        Route::post('datatable', $c . 'datatable')->name('datatable');
        Route::get('add', $c . 'add')->name('add');
        Route::post('add', $c . 'insert')->name('insert');
        Route::get('edit/{entity}', $c . 'edit')->name('edit');
        Route::post('edit/{entity}', $c . 'update')->name('update');
        Route::post('delete/{entity}', $c . 'delete')->name('delete');
        Route::post('changestatus/{entity}', $c . 'changestatus')->name('changestatus');
    });
    Route::prefix('tags')->name('tags.')->group(function () {
        $c = 'TagController@';
        
        Route::get('', $c . 'index')->name('index');
        Route::post('datatable', $c . 'datatable')->name('datatable');
        Route::get('add', $c . 'add')->name('add');
        Route::post('add', $c . 'insert')->name('insert');
        Route::get('edit/{entity}', $c . 'edit')->name('edit');
        Route::post('edit/{entity}', $c . 'update')->name('update');
        Route::post('delete/{entity}', $c . 'delete')->name('delete');
        Route::post('changestatus/{entity}', $c . 'changestatus')->name('changestatus');
    });
    Route::prefix('comments')->name('comments.')->group(function () {
        $c = 'CommentController@';

        Route::get('', $c . 'index')->name('index');
        Route::post('datatable', $c . 'datatable')->name('datatable');
        Route::post('delete/{entity}', $c . 'delete')->name('delete');
        Route::post('change-status/{entity}', $c . 'changeStatus')->name('change_status');
    });
});
