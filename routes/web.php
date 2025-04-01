<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/menu', function () {
    return view('pages.menu');
})->name('menu');

Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('/pricing', function () {
    return view('pages.pricing');
})->name('pricing');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/login', function () {
    return view('pages.login');
})->name('login');

Route::post('/login', function () {
    // Logique de soumission à ajouter plus tard
})->name('login.submit');

Route::get('/register', function () {
    return view('pages.register');
})->name('register');

Route::post('/register', function () {
    // Logique de soumission à ajouter plus tard
})->name('register.submit');