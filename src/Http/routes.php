<?php

Route::group(['prefix' => env('BASE_URL', ''), 'middleware' => 'web'], function () {

    Route::get('image/{id}_{width?}_{height?}_{type?}.{format?}', 'MediaController@getViewByFile')->where('id', '[^_\.]+');
    Route::get('image/{id}_{width?}_{height?}.{format?}', 'MediaController@getViewByFile')->where('id', '[^_\.]+');
    Route::get('image/{id}.{format?}', 'MediaController@getViewByFile')->where('id', '[^_\.]+');
    Route::get('image/{id}.{format?}', 'MediaController@getViewByFile');

    Route::get('file/{id}_{filename}.{format?}', 'MediaController@getFile')->where('id', '\d+');
    Route::get('view-file/{id}_{filename}.{format?}', 'MediaController@getViewFile')->where('id', '\d+');
    Route::get('view/{id}_{filename}.{format?}', 'MediaController@getFileView')->where('id', '\d+');
    Route::get('show/{filename}.{format?}', 'MediaController@showFile');

    Route::get('media/{id}_{width?}_{height?}_{type?}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('media/{id}_{width?}_{height?}.{format?}', 'MediaController@getView')->where('id', '\d+');
    Route::get('media/{id}.{format?}', 'MediaController@getViewWithoutResize')->where('id', '\d+');
    Route::get('media/{id}.{format?}', 'MediaController@getViewWithoutResize');
    Route::get('admin', 'Admin\AuthController@getLogin')->middleware('ipCheck');

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['ipCheck', 'cacheControl', 'permission']], function () {

        Route::get('auth/login', 'AuthController@getLogin')->name('admin.login');
        Route::post('auth/login', 'AuthController@login')->name('admin.login.post');

        Route::group(['middleware' => 'auth.admin'], function () {

            Route::get('auth/logout', 'AuthController@logout')->name('admin.logout');

            Route::get('structure', 'StructureController@getIndex')->name('admin.structure.index');
            Route::get('structure/index/{itemId?}', 'StructureController@getIndex')->name('admin.structure.item');
            Route::get('structure/active/{itemId}/{activeItemId}/{status}', 'StructureController@getActive')->name('admin.structure.active');
            Route::get('structure/delete/{parentId}/{itemId}', 'StructureController@getDelete')->name('admin.structure.delete');
            Route::get('structure/tree/{parentId}', 'StructureController@getTree')->name('admin.structure.tree');
            Route::get('structure/rebuild-tree', 'StructureController@getRebuildTree')->name('admin.structure.rebuild_tree');
            Route::post('structure/add/{itemId}/{prepend?}', 'StructureController@postAdd')->name('admin.structure.add');
            Route::post('structure/save/{itemId}', 'StructureController@postSave')->name('admin.structure.save');
            Route::post('structure/sort/{parentId}', 'StructureController@postSort')->name('admin.structure.sort');
            Route::post('structure/move', 'StructureController@postMove')->name('admin.structure.move');

            Route::get('gallery', 'GalleryController@getIndex')->name('admin.gallery.index');
            Route::get('gallery/index/{itemId?}/{select?}/{target?}', 'GalleryController@getIndex')->name('admin.gallery.item');
            Route::post('gallery/save-folder/{itemId?}/{id?}/{target?}', 'GalleryController@postSaveFolder')->name('admin.gallery.save_folder');
            Route::get('gallery/delete/{parentId}/{itemId}/{id?}', 'GalleryController@getDelete')->name('admin.gallery.delete');
            Route::any('gallery/upload/{itemId}/{id?}/{imageName?}', 'GalleryController@anyUpload')->name('admin.gallery.upload');
            Route::post('gallery/move', 'GalleryController@postMove')->name('admin.gallery.move');

            Route::get('types', 'TypeController@getIndex')->name('admin.types.index');
            Route::get('types/index', 'TypeController@getIndex')->name('admin.types.item');
            Route::get('types/add', 'TypeController@getAdd')->name('admin.types.add');
            Route::get('types/edit/{id}', 'TypeController@getEdit')->name('admin.types.edit');
            Route::post('types/save/{id?}', 'TypeController@postSave')->name('admin.types.save');
            Route::get('types/delete/{id}', 'TypeController@getDelete')->name('admin.types.delete');

            Route::get('administrators', 'AdministratorController@getIndex')->name('admin.administrators.index');
            Route::get('administrators/index', 'AdministratorController@getIndex')->name('admin.administrators.item');
            Route::get('administrators/add', 'AdministratorController@getAdd')->name('admin.administrators.add');
            Route::get('administrators/edit/{id}', 'AdministratorController@getEdit')->name('admin.administrators.edit');
            Route::post('administrators/save/{id?}', 'AdministratorController@postSave')->name('admin.administrators.save');
            Route::get('administrators/delete/{id}', 'AdministratorController@getDelete')->name('admin.administrators.delete');

            Route::get('translations', 'TranslationsController@getIndex')->name('admin.translations.index');
            Route::get('translations/index', 'TranslationsController@getIndex')->name('admin.translations.item');
            Route::get('translations/add', 'TranslationsController@postAdd')->name('admin.translations.add');
            Route::get('translations/edit/{id}', 'TranslationsController@getEdit')->name('admin.translations.edit');
            Route::post('translations/save/{id?}', 'TranslationsController@postSave')->name('admin.translations.save');
            Route::get('translations/delete/{id}', 'TranslationsController@getDelete')->name('admin.translations.delete');
            Route::get('translations/download/{languageId}', 'TranslationsController@download')->name('admin.translations.download');
            Route::post('translations/upload', 'TranslationsController@upload')->name('admin.translations.upload');

            Route::get('redirects', 'RedirectsController@getIndex')->name('admin.redirects.index');
            Route::get('redirects/index', 'RedirectsController@getIndex')->name('admin.redirects.item');
            Route::get('redirects/add', 'RedirectsController@getAdd')->name('admin.redirects.add');
            Route::get('redirects/edit/{id}', 'RedirectsController@getEdit')->name('admin.redirects.edit');
            Route::post('redirects/save/{id?}', 'RedirectsController@postSave')->name('admin.redirects.save');
            Route::get('redirects/delete/{id}', 'RedirectsController@getDelete')->name('admin.redirects.delete');

            Route::get('permissions/index', 'PermissionController@index')->name('admin.permissions.index');
            Route::get('permissions/delete/{id}', 'PermissionController@delete')->name('admin.permissions.delete');
            Route::resource('permissions', 'PermissionController', [
                'names' => [
                    'create' => 'admin.permissions.create',
                    'store' => 'admin.permissions.store',
                    'edit' => 'admin.permissions.edit',
                    'update' => 'admin.permissions.update',
                ]
            ]);

            Route::get('roles/index', 'RoleController@index')->name('admin.roles.index');
            Route::get('roles/delete/{id}', 'RoleController@delete')->name('admin.roles.delete');
            Route::resource('roles', 'RoleController', [
                'names' => [
                    'create' => 'admin.roles.create',
                    'store' => 'admin.roles.store',
                    'edit' => 'admin.roles.edit',
                    'update' => 'admin.roles.update',
                ]
            ]);

            Route::get('password', 'PasswordController@getIndex')->name('admin.password.index');
            Route::post('password', 'PasswordController@postIndex')->name('admin.password.save');

        });


    });

    if (config('larams.register_frontend_routes')) {
        Route::any('/', 'TypeController@anyIndex');
        Route::group(['prefix' => App::getLocale()], function () {
            Route::any('/', 'TypeController@anyIndex');
            Route::any('{url}/{url2?}/{url3?}/{url4?}/{url5?}/{url6?}/{url7?}', 'TypeController@anyIndex');
        });
        Route::any('{url}/{url2?}/{url3?}/{url4?}/{url5?}/{url6?}/{url7?}', 'TypeController@anyIndex');
    }

});
