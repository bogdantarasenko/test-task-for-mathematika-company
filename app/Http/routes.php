<?php


Route::get('/','MainController@index');

Route::get('/add','MainController@add');

Route::get('/delete/{id}','MainController@delete');

Route::get('/update/{id}','MainController@add');

Route::post('/getcitieslist','MainController@getcitieslist');

Route::post('/addtodb','MainController@addtodb');

Route::post('/update','MainController@update');


