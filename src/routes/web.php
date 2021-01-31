<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Quantic\SessionOut\Http\Controllers', 'middleware' => ['web']], function () {
    Route::post('/check-auth', 'AuthCheckCtrl@getStatus')->name('session-out.check-auth');
});
