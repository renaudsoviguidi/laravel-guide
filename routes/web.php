<?php

use Dedoc\Scramble\Scramble;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::domain('docs.example.com')->group(function () {
    Scramble::registerUiRoute('api');
    Scramble::registerJsonSpecificationRoute('api.json');
});