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

use App\Http\Controllers\PublicationController;
//BLOG
Route::resource('publications', PublicationController::class);
// Gestion des catégories
Route::get('/admin/categories', [PublicationController::class, 'listCategories'])->name('admin.listCategories');
Route::get('/admin/categories/add', [PublicationController::class, 'createCategory'])->name('admin.createCategory');
Route::post('/admin/categories/store', [PublicationController::class, 'storeCategory'])->name('admin.storeCategory');
Route::delete('/admin/categories/{id}', [PublicationController::class, 'deleteCategory'])->name('admin.deleteCategory');
Route::put('/admin/categories/{id}', [PublicationController::class, 'updateCategory'])->name('admin.updateCategory');

//Boutique 
//Produit
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);


Route::get('/test',function(){
    return view("admin.layout.index");
});
Route::get('/create-article',function(){
    return view("admin.layout.blog.create-article");
});

Route::get('/dashboard', [UserController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


use App\Http\Controllers\AdminController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;

//Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    // Produits
    Route::get('/produits', [ProductController::class, 'index'])->name('admin.produits.index');
    Route::get('/produits/create', [ProductController::class, 'create'])->name('admin.produits.create');
    Route::post('/produits', [ProductController::class, 'store'])->name('admin.produits.store');

    // Catégories
    Route::get('/categoriesA', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categoriesA/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categoriesA', [CategoryController::class, 'store'])->name('admin.categories.store');

    // Commandes
    Route::get('/commandes', [CommandeController::class, 'index'])->name('admin.commandes.index');

    // Paiements
    Route::get('/paiements', [PaiementController::class, 'index'])->name('admin.paiements.index');
//});
