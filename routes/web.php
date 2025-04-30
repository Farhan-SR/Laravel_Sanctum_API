<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/posts', function () {
    return view('posts');
});
Route::get('/addpost', function () {
    return view('addpost');
});
Route::get('/login', function () {
    return view('login');
});
Route::fallback(function () {
    return response()->json(['error' => 'Not Found. Wrong route.'], 404);
});