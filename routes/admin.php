<?php

use Illuminate\Support\Facades\Route;
Route::get('admin-login', 'Auth\LoginController@LoginAdmin')->name('admin-login');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin','prefix' => 'admin',], function () {
  Route::resource('dashboard','DashBoardController');
});
