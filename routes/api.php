<?php

Route::get('articles', 'ArticlesController@index');
Route::get('articles/{article}', 'ArticlesController@show');
Route::post('articles', 'ArticlesController@store');
Route::get('articles/{article}/edit', 'ArticlesController@edit');
Route::patch('articles/{article}', 'ArticlesController@update');
Route::delete('articles/{article}', 'ArticlesController@destroy');

Route::get('user/articles', 'ArticlesController@userArticles');

Route::get('tags', 'TagsController@index');
Route::get('tags/{tag}', 'TagsController@show');

Route::get('favorites', 'FavoritesController@index');
Route::get('is_favorite/{article}', 'FavoritesController@isFavorited');
Route::post('favorites/{article}', 'FavoritesController@favorite');

