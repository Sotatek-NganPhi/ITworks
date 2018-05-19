<?php

Route::get('/login','Manage\LoginController@showLoginForm');

Route::post('/login','Manage\LoginController@login');

Route::group(['middleware' => 'manage.auth'], function () {
    Route::get('/', 'Manage\ManagerController@index');

    Route::post('/logout','Manage\LoginController@logout');
});