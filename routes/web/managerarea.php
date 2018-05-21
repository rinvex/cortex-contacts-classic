<?php

declare(strict_types=1);

Route::domain('{subdomain}.'.domain())->group(function () {
    Route::name('managerarea.')
         ->namespace('Cortex\Contacts\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.managerarea') : config('cortex.foundation.route.prefix.managerarea'))->group(function () {

            // Contacts Routes
             Route::name('contacts.')->prefix('contacts')->group(function () {
                 Route::get('/')->name('index')->uses('ContactsController@index');
                 Route::get('import')->name('import')->uses('ContactsController@import');
                 Route::post('import')->name('stash')->uses('ContactsController@stash');
                 Route::post('hoard')->name('hoard')->uses('ContactsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('ContactsController@importLogs');
                 Route::get('create')->name('create')->uses('ContactsController@create');
                 Route::post('create')->name('store')->uses('ContactsController@store');
                 Route::get('{contact}')->name('edit')->uses('ContactsController@edit');
                 Route::put('{contact}')->name('update')->uses('ContactsController@update');
                 Route::get('{contact}/logs')->name('logs')->uses('ContactsController@logs');
                 Route::delete('{contact}')->name('destroy')->uses('ContactsController@destroy');
             });
         });
});
