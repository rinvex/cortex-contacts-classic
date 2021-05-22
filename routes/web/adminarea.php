<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Contacts\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Contacts Routes
             Route::name('cortex.contacts.contacts.')->prefix('contacts')->group(function () {
                 Route::get('/')->name('index')->uses('ContactsController@index');
                 Route::get('import')->name('import')->uses('ContactsController@import');
                 Route::post('import')->name('stash')->uses('ContactsController@stash');
                 Route::post('hoard')->name('hoard')->uses('ContactsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('ContactsController@importLogs');
                 Route::get('create')->name('create')->uses('ContactsController@create');
                 Route::post('create')->name('store')->uses('ContactsController@store');
                 Route::get('{contact}')->name('show')->uses('ContactsController@show');
                 Route::get('{contact}/edit')->name('edit')->uses('ContactsController@edit');
                 Route::put('{contact}/edit')->name('update')->uses('ContactsController@update');
                 Route::match(['get', 'post'], '{contact}/logs')->name('logs')->uses('ContactsController@logs');
                 Route::delete('{contact}')->name('destroy')->uses('ContactsController@destroy');
             });
         });
});
