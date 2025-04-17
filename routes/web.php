<?php
use Illuminate\Support\Facades\Route;


// Routes publiques
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/menu', function () {
    return view('pages.menu');
})->name('menu');

Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Mise à jour pour utiliser le contrôleur
Route::get('/restaurants', [App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurants');
Route::get('/restaurant/{id}', [App\Http\Controllers\RestaurantController::class, 'show'])->name('restaurant.show');

// Routes d'authentification
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    
    // Routes pour l'administrateur
    Route::middleware(['role:Administrateur'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
        Route::delete('/users/{id}', [UserController::class, 'delete'])->name('admin.users.delete');

        Route::get('/profile', 'App\Http\Controllers\Admin\ProfileController@index')->name('admin.profile');
        Route::get('/profile/edit', 'App\Http\Controllers\Admin\ProfileController@edit')->name('admin.profile.edit');
        Route::put('/profile', 'App\Http\Controllers\Admin\ProfileController@update')->name('admin.profile.update');
        Route::delete('/profile/image', 'App\Http\Controllers\Admin\ProfileController@deleteImage')->name('admin.profile.delete_image');

        // Routes pour la gestion des catégories
        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        Route::get('/restaurants', [App\Http\Controllers\Admin\RestaurantController::class, 'index'])->name('admin.restaurants.index');
        Route::delete('/restaurants/{id}', [App\Http\Controllers\Admin\RestaurantController::class, 'destroy'])->name('admin.restaurants.destroy');
    });
    
    // Routes pour le gérant (nécessite un compte approuvé)
    Route::middleware(['role:Gérant'])->prefix('gerant')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.gerant.dashboard');
        })->name('gerant.dashboard');

        Route::get('/profile', 'App\Http\Controllers\Gerant\ProfileController@index')->name('gerant.profile');
        Route::get('/profile/edit', 'App\Http\Controllers\Gerant\ProfileController@edit')->name('gerant.profile.edit');
        Route::put('/profile', 'App\Http\Controllers\Gerant\ProfileController@update')->name('gerant.profile.update');
        Route::delete('/profile/image', 'App\Http\Controllers\Gerant\ProfileController@deleteImage')->name('gerant.profile.delete_image');

        Route::get('/restaurant', [App\Http\Controllers\Gerant\RestaurantController::class, 'index'])->name('gerant.restaurant.index');
        Route::get('/restaurant/create', [App\Http\Controllers\Gerant\RestaurantController::class, 'create'])->name('gerant.restaurant.create');
        Route::post('/restaurant', [App\Http\Controllers\Gerant\RestaurantController::class, 'store'])->name('gerant.restaurant.store');
        Route::get('/restaurant/edit', [App\Http\Controllers\Gerant\RestaurantController::class, 'edit'])->name('gerant.restaurant.edit');
        Route::put('/restaurant', [App\Http\Controllers\Gerant\RestaurantController::class, 'update'])->name('gerant.restaurant.update');
        Route::post('/restaurant/toggle-category', [App\Http\Controllers\Gerant\RestaurantController::class, 'toggleCategory'])->name('gerant.restaurant.toggle-category');
    });

    // Routes pour le client
    Route::middleware(['role:Client'])->prefix('client')->group(function () {
        Route::get('/dashboard', function () {
            return view('client.dashboard');
        })->name('client.dashboard');
      
        Route::get('/profile', 'App\Http\Controllers\Client\ProfileController@index')->name('client.profile');
        Route::get('/profile/edit', 'App\Http\Controllers\Client\ProfileController@edit')->name('client.profile.edit');
        Route::put('/profile', 'App\Http\Controllers\Client\ProfileController@update')->name('client.profile.update');
        Route::delete('/profile/image', 'App\Http\Controllers\Client\ProfileController@deleteImage')->name('client.profile.delete_image');
    });
});