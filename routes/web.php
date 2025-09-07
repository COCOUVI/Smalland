<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.index');
})->name('accueil');
Route::get('/espace-etudiant', function () {
    return view('layouts.space-etudiant.dashboard');
})->name('espace');
Route::get('/formation-detail', function () {
    return view('layouts.formation.formation-detail');
})->name('formation-detail');
Route::get('/formation-list', function () {
    return view('layouts.formation.formation-catalog');
})->name('formation-list');
Route::get('/cart', function () {
    return view('layouts.boutique.cart');
})->name('cart');
Route::get('/cart', function () {
    return view('layouts.boutique.cart');
})->name('cart');
Route::get('/cart', function () {
    return view('layouts.boutique.cart');
})->name('cart');
Route::get('/cart', function () {
    return view('layouts.boutique.cart');
})->name('cart');