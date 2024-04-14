<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KanyeQuoteController;
use App\Http\Middleware\CheckToken;

Route::get('/', function () {
    return view('app');
});

Route::group(['middleware' => [CheckToken::class, 'throttle:60,1']], function () {
    Route::get('/kanye-quotes', KanyeQuoteController::class);
});