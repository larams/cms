<?php

Route::group( ['prefix' => env('BASE_URL', '') ], function () {

    Route::get('media/{id}_{width?}_{height?}_{type?}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('media/{id}_{width?}_{height?}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('media/{id}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('admin', 'Admin\AuthController@getLogin');

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

        Route::controller('auth', 'AuthController');

        Route::group(['middleware' => 'auth'], function () {

            Route::controller('structure', 'StructureController');
            Route::controller('gallery', 'GalleryController');
            Route::controller('types', 'TypeController');
            Route::controller('administrators', 'AdministratorController');

        });


    });

    Route::get('/', 'TypeController@getIndex');
    Route::get('{url}/{url2?}/{url3?}/{url4?}/{url5?}/{url6?}/{url7?}', 'TypeController@getIndex');


} );