<?php

Route::group(['prefix' => 'v1/auth', 'as' => 'auth.', 'namespace' => 'Api\V1\Admin\Auth'], function () {
    Route::post('login', 'AuthApiController@login');
    Route::post('register', 'AuthAPiController@register');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Todo
    Route::apiResource('todos', 'TodoApiController');
});
