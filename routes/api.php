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
        
        /**
         * Test the connection to the api,
         * THIS IS A  DUMMY ENDPOINT
         */
        Route::get('robots', function () {
            return "These are not the droids you're looking for... \nv " . config('app.api_version');
        });
        
        Route::post('log', function () {
            return response(["success" => TRUE]);
        });
        
        Route::get('log', function () {
            return response(["success" => TRUE, "data" => []]);
        });
        
        Route::post('action', function () {
            return response(["success" => TRUE]);
        });
    
    });
