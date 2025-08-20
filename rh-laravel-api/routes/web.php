<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// WEB routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('/ping', function () {
    Log::info('Ping endpoint');
    return response()->json(['pong' => true]);
});
