<?php

Route::get('/{vue}', function () {
    return view('welcome');
})->where('vue', '[\/\w\.-]*');;

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');
    Route::post('register', 'RegisterController@register');
});