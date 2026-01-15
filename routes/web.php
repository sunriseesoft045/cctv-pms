<?php

use App\Http\Controllers\CameraResourceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cameras', CameraResourceController::class);
