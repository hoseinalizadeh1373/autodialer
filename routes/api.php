<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace'=>'App\Http\Controllers\Api'],function(){
    Route::post('announcement/upload','AutoDialerController@announcementsUpload');
});