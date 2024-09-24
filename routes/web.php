<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.master');
});

Route::get('/products', function () {
    return view('productview');
});

Route::get('/products_listing', function () {
    return view('productfilter');
});

Route::get('/wishlist', function () {
    return view('bookmark');
});

Route::get('/privacypolicy', function () {
    return view('privacypolicy');
});

Route::get('/termsandconditions', function () {
    return view('termsandconditions');
});