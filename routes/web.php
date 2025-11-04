<?php
require __DIR__.'/auth.php';
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttestationController;
use App\Http\Middleware\EnsureUserIsClient;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ProductController;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// === ROUTES PUBLIQUES ===
Route::get('/', [HomeController::class, 'index'])->name('accueil');
// Route::get('/espace-etudiant', fn() => view('layouts.space-etudiant.dashboard'))->name('student.dashboard');
// Route::get('/formation-detail', fn() => view('layouts.formation.formation-detail'))->name('formation-detail');
// Route::get('/formation-list', fn() => view('layouts.formation.formation-catalog'))->name('formations.catalog');


Route::get('/order', fn() => view('layouts.boutique.order-tracking'))->name('order.tracking');
Route::get('/cart', fn() => view('layouts.boutique.cart'))->name('cart');
Route::get('/test', fn() => view("admin.layout.index"));
Route::get('/create-article', fn() => view("admin.layout.blog.create-article"));

// BLOG
Route::resource('publications', PublicationController::class);
Route::get('/blog-list', [PublicationController::class, 'index1'])->name('blog.list');
Route::get('/blog/{id}', [PublicationController::class, 'show'])->name('blog.show');
Route::get('/blog-category', [PublicationController::class, 'categories'])->name('blog.category');
Route::get('/blog/category/{id}', [PublicationController::class, 'articles'])->name('blog.articles');

// Gestion des catégories
Route::get('/admin/categories', [PublicationController::class, 'listCategories'])->name('admin.listCategories');
Route::get('/admin/categories/add', [PublicationController::class, 'createCategory'])->name('admin.createCategory');
Route::post('/admin/categories/store', [PublicationController::class, 'storeCategory'])->name('admin.storeCategory');
Route::delete('/admin/categories/{id}', [PublicationController::class, 'deleteCategory'])->name('admin.deleteCategory');
Route::put('/admin/categories/{id}', [PublicationController::class, 'updateCategory'])->name('admin.updateCategory');

// Boutique - Produit
Route::resource('products', ProductController::class);
Route::get('/product-list', [ProductController::class, 'shop'])->name('shop');
Route::get('/produits/{product}', [ProductController::class, 'voir'])->name('admin.produits.voir');

// Formations publiques
Route::get('/formation-detail/{formation}', [HomeController::class, 'ShowOneFormation'])->name('formation-detail');
Route::get('/formation-list', [HomeController::class, 'showFormations'])->name('formation-list');
Route::get('/formations/{formation}/avis', [HomeController::class, 'AfficherTousLesAvis'])
    ->name('formations.avis');

//Route pour l'espace etudiant
Route::prefix('espace-etudiant')->middleware(['auth','verified',EnsureUserIsClient::class])->group(function () {
    Route::get('/', [StudentController::class, "index"])->name('espace.etudiant');
    Route::get('/mes-formations', [StudentController::class, "ShowTranings"])->name('trainings.paid');
    Route::get('/mes-certificats', [StudentController::class, 'Showcertfication'])->name('certificats.index');
    Route::get('/facturations', [StudentController::class, 'ShowFacturations'])->name('facturations.index');
    Route::get('/help', [StudentController::class, 'Showhelp'])->name('help.index');
    Route::post('/help', [StudentController::class, 'sendMail'])->name('help.send');
    Route::get('/parametres', [StudentController::class, 'ShowSettings'])->name('parametres.index');
    Route::post('/parametres/update', [StudentController::class, 'update'])->name('parametres.update');
});



//ROUTE FOR THE PAIEMENTS
Route::prefix('paiement')->group(function () {
    // Initier le paiement (utilisateur connecté)
    // Route::get('/{formation}', [PaymentController::class, 'initier'])
    //     ->name('paiement.initier')
    //     ->middleware('auth');

    // Callback KKiaPay (publique)
    Route::any('/api/callback', [PaymentController::class, 'callback'])
        ->name('paiement.callback');

    Route::post('/initier/{formation}', [PaymentController::class, 'initierAjax'])
        ->name('paiement.initier.ajax')
        ->middleware('auth')
    ;
});

// Paiements
Route::prefix('paiement')->group(function () {
    Route::any('/api/callback', [PaymentController::class, 'callback'])->name('paiement.callback');
    Route::post('/initier/{formation}', [PaymentController::class, 'initierAjax'])->name('paiement.initier.ajax')->middleware('auth');
});
Route::any('/api/webhook', [PaymentController::class, 'webhook'])->name('paiement.webhook')->withoutMiddleware(VerifyCsrfToken::class);

// Dashboard utilisateur
Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Zone admin
Route::prefix('dashboard')->middleware(['auth', 'admin'])->group(function () {
    // Formations
    Route::get('/add-formation', [AdminController::class, "AddFormationPage"])->name('add_formation_page');
    Route::post('/submit-formation', [AdminController::class, "AddFormation"])->name("store_formation");
    Route::get('/list_formation', [AdminController::class, "ShowFormations"])->name('lists_formation');
    Route::get('/details/{formation}', [AdminController::class, "GetOneFormation"])->name("details.formation");
    Route::get('/page_modify_formation/{formation}', [AdminController::class, "Put_Page_Formation"])->name('put_page.formation');
    Route::put('/modify_formation/{formation}', [AdminController::class, 'PutFormation'])->name('admin.formations.update');
    Route::delete('/delete_formation/{formation}', [AdminController::class, "DeleteFormation"])->name('delete.formation');
    Route::get('/formations/{formation}/objectives', [AdminController::class, 'getObjectives'])->name('formations.objectives');

    // Modules
    Route::get('/formations/{formation}/modules', [AdminController::class, 'getModules'])->name('modules.get');
    Route::get('/modules', [AdminController::class, 'listModules'])->name('modules.list');
    Route::post('/formations/{formation}/modules', [AdminController::class, 'AddModule'])->name('modules.store');
    Route::put('/modules/{module}', [AdminController::class, 'updateModule'])->name('modules.update');
    Route::delete('/modules/{module}', [AdminController::class, 'deleteModule'])->name('modules.delete');

    // Leçons
    Route::post('/modules/{moduleId}/lessons', [AdminController::class, 'addLesson'])->name('lessons.store');
    Route::get('/modules/{moduleId}/lessons', [AdminController::class, 'getLessons'])->name('lessons.get');
    Route::put('/lessons/{lessonId}', [AdminController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/lessons/{lessonId}', [AdminController::class, 'destroyLesson'])->name('lessons.delete');
    Route::get('/lessons', [AdminController::class, 'listLessons'])->name('lessons.list');

    // Quiz
    Route::get('/modules/{module}/quizz', [QuizzController::class, 'manage'])->name('quizz.manage');
    Route::post('/modules/{module}/quizz/store', [QuizzController::class, 'storeOrUpdate'])->name('quizz.storeOrUpdate');
    Route::put('/questions/{questionId}', [QuizzController::class, 'updateQuestion'])->name('questions.update');
    Route::delete('/questions/{questionId}', [QuizzController::class, 'deleteQuestion'])->name('questions.delete');
    Route::put('/quizz/{quizz}/update-title', [QuizzController::class, 'updateTitle'])->name('quizz.updateTitle');
    Route::delete('/quizz/{quizz}', [QuizzController::class, 'destroy'])->name('quizz.destroy');

    Route::get('/listes-paiments', [AdminController::class, "Showpaiements"])->name('admin.paiements.index');
    Route::get('/certification-list', [AdminController::class, "ShowCertifications"])->name("certif-list");
});

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin - Produits
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/produits', [ProductController::class, 'index'])->name('admin.produits.index');
    Route::get('/produits/create', [ProductController::class, 'create'])->name('admin.produits.create');
    Route::post('/produits', [ProductController::class, 'store'])->name('admin.produits.store');
        Route::put('/produits/{product}', [ProductController::class, 'update'])->name('admin.produits.update');
    Route::delete('/produits/{product}', [ProductController::class, 'destroy'])->name('admin.produits.destroy');

    // Catégories
    Route::get('/categoriesA', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categoriesA/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categoriesA', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categoriesA/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categoriesA/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categoriesA/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Paiements (duplicat évité ici)
    Route::get('/paiements', [PaiementController::class, 'index'])->name('admin.paiements');
});

// === ROUTES POUR LES UTILISATEURS AUTHENTIFIÉS ===
Route::middleware(['auth'])->group(function () {
    // Formations
    Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');
    Route::get('/formations/{id}', [FormationController::class, 'show'])->name('formations.show');

    // Modules
    Route::get('/formations/{formationId}/modules/{moduleId}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/lessons/{lessonId}/complete', [ModuleController::class, 'completeLesson']);

    // Quizz
    Route::get('/quizz/{quizz}', [QuizzController::class, 'show'])->name('quizz.show');
    Route::post('/quizz/{quizz}/submit', [QuizzController::class, 'submit'])->name('quizz.submit');

    // Avis
    Route::post('/formations/{formation}/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::get('/formations/{formation}/avis/edit', [AvisController::class, 'edit'])->name('avis.edit');
    Route::put('/formations/{formation}/avis', [AvisController::class, 'update'])->name('avis.update');
    Route::delete('/formations/{formation}/avis', [AvisController::class, 'destroy'])->name('avis.destroy');

    //Certificat
    Route::get('/formations/{id}/attestation', [AttestationController::class, 'download'])
    ->name('formations.attestation')
    ->middleware('auth');
});

// Commande 


// Routes nécessitant l'authentification
Route::middleware(['auth'])->group(function () {
    
    // CART ROUTES
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });

    // CHECKOUT ROUTES
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
        Route::post('/shipping-fee', [CheckoutController::class, 'getShippingFee'])->name('shipping-fee');
    });

    // ORDER ROUTES (Client)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('invoice');
    });
});
// Callback de paiement (unifié pour formations ET commandes)
Route::get('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');