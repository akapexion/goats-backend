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

Route::get('/storage/{path}', function ($path) {
    $cleanPath = ltrim($path, '/');
    $possiblePaths = [
        storage_path('app/public/' . $cleanPath),
        public_path('storage/' . $cleanPath),
        public_path($cleanPath),
        storage_path('app/' . $cleanPath),
    ];

    foreach ($possiblePaths as $file) {
        if (file_exists($file) && !is_dir($file)) {
            return response()->file($file);
        }
    }

    abort(404);
})->where('path', '.*');
