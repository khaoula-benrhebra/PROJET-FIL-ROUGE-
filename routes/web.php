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


// Route::get('/dashboard', function () {
//     return view('pages.gerant.dashboard');
// })->name('gerant.dashboard');

// Route::get('/dashboard', function () {
//     return view('pages.gerant.dashboard');
// })->name('gerant.dashboard');

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;



// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    
    // Routes pour l'administrateur
    Route::middleware(['auth'])->group(function () {
        Route::middleware(['role:Administrateur'])->prefix('admin')->group(function () {
            Route::get('/dashboard', [UserController::class, 'index'])->name('admin.dashboard');
            Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
            Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
            Route::delete('/users/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
        });
    });
    
    // Routes pour le gérant (nécessite un compte approuvé)
    Route::middleware(['role:Gérant'])->prefix('gerant')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.gerant.dashboard');
        })->name('gerant.dashboard');
    });
    
    // Routes pour le client
    Route::middleware(['role:Client'])->prefix('client')->group(function () {
        Route::get('/dashboard', function () {
            return view('client.dashboard');
        })->name('client.dashboard');
    });
});