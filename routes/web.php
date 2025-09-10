<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/test',function(){
    return view("admin.layout.index");
});

Route::get('/dashboard', [UserController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
