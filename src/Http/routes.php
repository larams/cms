<?php

Route::group( ['prefix' => env('BASE_URL', ''), 'middleware' => 'web' ], function () {

    Route::get('image/{id}_{width?}_{height?}_{type?}.{format?}', 'MediaController@getViewByFile')->where('id', '[^_\.]+');
    Route::get('image/{id}_{width?}_{height?}.{format?}', 'MediaController@getViewByFile')->where('id', '[^_\.]+');
    Route::get('image/{id}.{format?}', 'MediaController@getViewByFile')->where('id', '[^_\.]+');
    Route::get('image/{id}.{format?}', 'MediaController@getViewByFile');

    Route::get('file/{id}_{filename}.{format?}', 'MediaController@getFile')->where('id', '\d+');
    Route::get('view/{id}_{filename}.{format?}', 'MediaController@getFileView')->where('id', '\d+');

    Route::get('media/{id}_{width?}_{height?}_{type?}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('media/{id}_{width?}_{height?}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('media/{id}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('media/{id}.{format?}', 'MediaController@getView');
    Route::get('admin', 'Admin\AuthController@getLogin');

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

        Route::controller('auth', 'AuthController');

        Route::group(['middleware' => 'auth'], function () {

            Route::controller('structure', 'StructureController');
            Route::controller('gallery', 'GalleryController');
            Route::controller('types', 'TypeController');
            Route::controller('administrators', 'AdministratorController');
            Route::controller('translations', 'TranslationsController');

        });


    });

    Route::any('/', 'TypeController@anyIndex');

    Route::group(['prefix' => App::getLocale() ], function() {

        Route::any('/', 'TypeController@anyIndex');
        Route::any('{url}/{url2?}/{url3?}/{url4?}/{url5?}/{url6?}/{url7?}', 'TypeController@anyIndex');

    } );

    Route::any('{url}/{url2?}/{url3?}/{url4?}/{url5?}/{url6?}/{url7?}', 'TypeController@anyIndex');

} );