<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
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

Route::get('/test', function () {
    return view("admin.layout.formations.index");
});

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

//admin route
Route::prefix('dashboard')->group(function () {

    Route::get('/add-formation', [AdminController::class, "AddFormationPage"])->name('add_formation_page');
    Route::post('/submit-formation', [AdminController::class, "AddFormation"])->name("store_formation");
    Route::get('/list_formation', [AdminController::class, "ShowFormations"])->name('lists_formation');
    Route::get('/details/{formation}', [AdminController::class, "GetOneFormation"])->name("details.formation");
    Route::get('/page_modify_formation/{formation}', [AdminController::class, "Put_Page_Formation"])->name('put_page.formation');
    Route::put('/modify_formation/{formation}', [AdminController::class, 'PutFormation'])->name('admin.formations.update');
    Route::delete('/delete_formation/{formation}', [AdminController::class, "DeleteFormation"])->name('delete.formation');

    // Route pour ajouter des modules via AJAX
    Route::post('/formations/{formation}/modules', [AdminController::class, 'AddModule'])->name('modules.store');
    Route::get('/formations/{formation}/modules', [AdminController::class, 'getModules'])->name('modules.get');
})->middleware(["auth", 'admin']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
