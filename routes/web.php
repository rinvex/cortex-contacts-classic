<?php

declare(strict_types=1);

Route::group(['domain' => domain()], function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Contacts\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Contacts Routes
        Route::name('contacts.')->prefix('contacts')->group(function () {
            Route::get('/')->name('index')->uses('ContactsController@index');
            Route::get('create')->name('create')->uses('ContactsController@form');
            Route::post('create')->name('store')->uses('ContactsController@store');
            Route::get('{contact}')->name('edit')->uses('ContactsController@form');
            Route::put('{contact}')->name('update')->uses('ContactsController@update');
            Route::get('{contact}/logs')->name('logs')->uses('ContactsController@logs');
            Route::delete('{contact}')->name('delete')->uses('ContactsController@delete');
        });

    });

});
