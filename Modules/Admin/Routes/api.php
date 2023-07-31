<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->get('/', function (Request $request) {
    return $request->user();
});
