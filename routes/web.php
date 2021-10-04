<?php

use Illuminate\Support\Facades\Route;

// -------- Error Pages ------------------ useless but they're there to test
Route::get('/error404','View\HomeViewController@getNotFoundPage')->name('error404');
Route::get('/error403','View\HomeViewController@getRightErrorPage')->name('error403');
Route::get('/error401','View\HomeViewController@getUnauthorizedPage')->name('error401');
Route::get('/error419','View\HomeViewController@getAuthenticationTimoutPage')->name('error419');
Route::get('/error429','View\HomeViewController@getTooManyRequestPage')->name('error429');
Route::get('/error500','View\HomeViewController@getInternalErrorPage')->name('error500');
Route::get('/error503','View\HomeViewController@getServiceUnavailablePage')->name('error503');
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
