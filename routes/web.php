<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name("index");

Route::get('/market', function () {
    return view("market");
})->name("market");

Route::get('/products', function () {
    return view("products");
})->name("products");

Route::get('/farmers/{market}', function ($market) {
    return view('farmers', compact('market'));
})->name('farmers');

Route::get('/admin/', function () {
    return view('admin.index');
})->name('admin');
