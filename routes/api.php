<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('halo', function(){

    $biodata = [
        'name' => 'Arjun Sinambela',
        'email' => 'zunedisinambela@gmail.com',
        'gender' => 'male',
        'mediasosial' => [
            [
                'facebook' => 'www.facebook.com/zunedisinambela',
                'instagram' => 'www.instagram.com/arjun.sinambela'
            ]
        ]
    ];

    return \Response::json($biodata);
});