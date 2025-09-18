<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// === ROUTES PUBLIQUES ===
Route::get('/', fn () => view('layouts.index'))->name('accueil');
Route::get('/espace-etudiant', fn () => view('layouts.space-etudiant.dashboard'))->name('espace');
Route::get('/formation-detail', fn () => view('layouts.formation.formation-detail'))->name('formation-detail');
Route::get('/formation-list', fn () => view('layouts.formation.formation-catalog'))->name('formation-list');
Route::get('/cart', fn () => view('layouts.boutique.cart'))->name('cart');
Route::get('/test', fn () => view("admin.layout.formations.index"));

// === DASHBOARD UTILISATEUR (ACCÈS AUTH) ===
Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// === ZONE ADMIN (PROTÉGÉE PAR MIDDLEWARE auth + admin) ===
Route::prefix('dashboard')->middleware(['auth', 'admin'])->group(function () {

    // FORMATIONS CRUD
    Route::get('/add-formation', [AdminController::class, "AddFormationPage"])->name('add_formation_page');
    Route::post('/submit-formation', [AdminController::class, "AddFormation"])->name("store_formation");
    Route::get('/list_formation', [AdminController::class, "ShowFormations"])->name('lists_formation');
    Route::get('/details/{formation}', [AdminController::class, "GetOneFormation"])->name("details.formation");
    Route::get('/page_modify_formation/{formation}', [AdminController::class, "Put_Page_Formation"])->name('put_page.formation');
    Route::put('/modify_formation/{formation}', [AdminController::class, 'PutFormation'])->name('admin.formations.update');
    Route::delete('/delete_formation/{formation}', [AdminController::class, "DeleteFormation"])->name('delete.formation');

    // MODULES
    Route::get('/formations/{formation}/modules', [AdminController::class, 'getModules'])->name('modules.get');
    Route::get('/modules', [AdminController::class, 'listModules'])->name('modules.list'); // Nouvelle route pour la liste
    Route::post('/formations/{formation}/modules', [AdminController::class, 'AddModule'])->name('modules.store');
    Route::put('/modules/{module}', [AdminController::class, 'updateModule'])->name('modules.update'); // Nouvelle route pour modifier
    Route::delete('/modules/{module}', [AdminController::class, 'deleteModule'])->name('modules.delete');
});

// === PROFIL UTILISATEUR (AUTH) ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// AUTHENTIFICATION (LARAVEL BREEZE / FORTIFY / JETSTREAM)
require __DIR__ . '/auth.php';
