<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KanyeQuoteController;

Route::get('/', function () {
    return view('app');
});

Route::group(['middleware' => ['throttle:60,1']], function () {
    Route::get('/kanye-quotes', KanyeQuoteController::class);
});