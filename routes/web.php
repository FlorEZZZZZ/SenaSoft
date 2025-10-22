<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {
    return view('flights.search');
});

Route::get('/search-results', function () {
    return view('flights.search-results');
});

Route::get('/bookings/create', function () {
    return view('bookings.create');
});

Route::get('/bookings/payment', function () {
    return view('bookings.payment');
});

Route::get('/bookings/confirmation', function () {
    return view('bookings.confirmation');
});

Route::get('/login', function () {
    return view('auth.login');
});