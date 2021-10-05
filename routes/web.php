<?php

use Illuminate\Support\Facades\Route;

// -------- Error Pages ------------------ useless but they're there to test
Route::get('/error404','App\Http\Controllers\View\ViewController@getNotFoundPage')->name('error404');
Route::get('/error403','App\Http\Controllers\View\ViewController@getRightErrorPage')->name('error403');
Route::get('/error401','App\Http\Controllers\View\ViewController@getUnauthorizedPage')->name('error401');
Route::get('/error419','App\Http\Controllers\View\ViewController@getAuthenticationTimoutPage')->name('error419');
Route::get('/error429','App\Http\Controllers\View\ViewController@getTooManyRequestPage')->name('error429');
Route::get('/error500','App\Http\Controllers\View\ViewController@getInternalErrorPage')->name('error500');
Route::get('/error503','App\Http\Controllers\View\ViewController@getServiceUnavailablePage')->name('error503');
// --------- End Error Pages ------------------

//Change Language
Route::get('/setLang/{lang}', function ($lang) {
    $supportedLang = config('qswg.lang');
    if(in_array($lang,$supportedLang))
    {
        session(["lang" => $lang]);
    }
    else
    {
        session(["lang" => 'en']);
    }
    return back();
})->middleware('setLocale');
Route::get('lang/get', function () {
    return session()->get('lang');
})->middleware('setLocale');
