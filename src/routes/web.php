<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Quantic\SessionOut\Http\Controllers', 'middleware' => ['web']], function () {
    Route::post('/check-auth', 'AuthCheckController@getStatus')->name('session-out.check-auth');
    Route::post('/session', 'AuthCheckController@setStatus')->name('session-out.session');
    Route::post('/rebirth-session', 'AuthCheckController@rebirthStatus')->name('session-out.rebirth');
});
