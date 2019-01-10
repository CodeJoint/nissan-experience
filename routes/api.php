<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/robots', function (Request $request) {
    return response("These aren't the droids you're looking for", 200);
});
