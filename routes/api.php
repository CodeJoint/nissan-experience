<?php

use Illuminate\Http\Request;

    /*   ___  ______ _____  ______            _   _
	 *  / _ \ | ___ \_   _| | ___ \          | | (_)
	 * / /_\ \| |_/ / | |   | |_/ /___  _   _| |_ _ _ __   __ _
	 * |  _  ||  __/  | |   |    // _ \| | | | __| | '_ \ / _` |
	 * | | | || |    _| |_  | |\ \ (_) | |_| | |_| | | | | (_| |
	 * \_| |_/\_|    \___/  \_| \_\___/ \__,_|\__|_|_| |_|\__, |
	 *                                                     __/ |
	 *                                                     |___/
	 * Author: John Falcon for Intus
	 * Version: 1.2.1
	 * Website: http://pixelton.xyz
	 */
    Route::group( [ 'domain' => config('api_base_url'), 'middleware' => ['cors'] ], function () {
        
        Route::get('/', function () {
            abort(403);
        });
        
        /**
         * Test the connection to the api,
         * THIS IS A  DUMMY ENDPOINT
         */
        Route::get('ping', function () {
            return response("These are not the droids you're looking for... \nv " . config('app.api_version'), 200);
        });
        
        Route::post('log', "LogController@store");
        
        Route::get('log', "LogController@index");
        
        Route::post('event', "LogController@storeEvent");
    
        Route::post('stores', "DeviceController@createStore");
        
        Route::get('stores', "DeviceController@indexStores");
        
        Route::get('devices', "DeviceController@index");
    
        Route::post('devices', "DeviceController@store");
    
    });
