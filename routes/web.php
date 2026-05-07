<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/coming-soon', function () {
    return view('soon');
})->name('coming-soon');

Route::get('/contact-us', function () {
    return view('pages.contact-us');
})->name('contact-us');
