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
    Route::get('admin', 'Admin\AuthController@getLogin')->middleware('ipCheck');

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'ipCheck'], function () {

        Route::get('auth/login', 'AuthController@getLogin');
        Route::post('auth/login', 'AuthController@postLogin');

        Route::group(['middleware' => 'auth'], function () {

            Route::get('structure', 'StructureController@getIndex');
            Route::get('structure/index/{itemId?}', 'StructureController@getIndex');
            Route::get('structure/active/{itemId}/{activeItemId}/{status}', 'StructureController@getActive');
            Route::get('structure/delete/{parentId}/{itemId}', 'StructureController@getDelete');
            Route::get('structure/tree/{parentId}', 'StructureController@getTree');
            Route::get('structure/rebuild-tree', 'StructureController@getRebuildTree');
            Route::post('structure/add/{itemId}/{prepend?}', 'StructureController@postAdd');
            Route::post('structure/save/{itemId}', 'StructureController@postSave');
            Route::post('structure/sort/{parentId}', 'StructureController@postSort');
            Route::post('structure/move', 'StructureController@postMove');

            Route::get('gallery', 'GalleryController@getIndex');
            Route::get('gallery/index/{itemId?}/{select?}/{target?}', 'GalleryController@getIndex');
            Route::post('gallery/save-folder/{itemId?}', 'GalleryController@postSaveFolder');
            Route::get('gallery/delete/{parentId}/{itemId}', 'GalleryController@getDelete');
            Route::any('gallery/upload/{itemId}', 'GalleryController@anyUpload');
            Route::post('gallery/move', 'GalleryController@postMove');

            Route::get('types', 'TypeController@getIndex');
            Route::get('types/index', 'TypeController@getIndex');
            Route::get('types/add', 'TypeController@getAdd');
            Route::get('types/edit/{id}', 'TypeController@getEdit');
            Route::post('types/save/{id?}', 'TypeController@postSave');
            Route::get('types/delete/{id}', 'TypeController@getDelete');

            Route::get('administrators', 'AdministratorController@getIndex');
            Route::get('administrators/index', 'AdministratorController@getIndex');
            Route::get('administrators/add', 'AdministratorController@getAdd');
            Route::get('administrators/edit/{id}', 'AdministratorController@getEdit');
            Route::post('administrators/save/{id?}', 'AdministratorController@postSave');
            Route::get('administrators/delete/{id}', 'AdministratorController@getDelete');

            Route::get('translations', 'TranslationsController@getIndex');
            Route::get('translations/index', 'TranslationsController@getIndex');
            Route::get('translations/add', 'TranslationsController@getAdd');
            Route::get('translations/edit/{id}', 'TranslationsController@getEdit');
            Route::post('translations/save/{id?}', 'TranslationsController@postSave');
            Route::get('translations/delete/{id}', 'TranslationsController@getDelete');

        });


    });

    Route::any('/', 'TypeController@anyIndex');

    Route::group(['prefix' => App::getLocale() ], function() {

        Route::any('/', 'TypeController@anyIndex');
        Route::any('{url}/{url2?}/{url3?}/{url4?}/{url5?}/{url6?}/{url7?}', 'TypeController@anyIndex');

    } );

    Route::any('{url}/{url2?}/{url3?}/{url4?}/{url5?}/{url6?}/{url7?}', 'TypeController@anyIndex');

} );