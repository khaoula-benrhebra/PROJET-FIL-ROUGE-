<?php
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/about', function () {return view('pages.about');})->name('about');


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
    Route::middleware(['role:Gérant'])->prefix('gerant')->name('gerant.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Gerant\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/reservations/{id}/status', [App\Http\Controllers\Gerant\DashboardController::class, 'updateReservationStatus'])->name('reservations.update-status');
    
        Route::get('/profile', 'App\Http\Controllers\Gerant\ProfileController@index')->name('profile');
        Route::get('/profile/edit', 'App\Http\Controllers\Gerant\ProfileController@edit')->name('profile.edit');
        Route::put('/profile', 'App\Http\Controllers\Gerant\ProfileController@update')->name('profile.update');
        Route::delete('/profile/image', 'App\Http\Controllers\Gerant\ProfileController@deleteImage')->name('profile.delete_image');

        Route::get('/menu', [App\Http\Controllers\Gerant\MenuController::class, 'index'])->name('menu');
        Route::get('/meals/create', [App\Http\Controllers\Gerant\MenuController::class, 'createMeal'])->name('meals.create');
        Route::post('/meals', [App\Http\Controllers\Gerant\MenuController::class, 'storeMeal'])->name('meals.store');
        Route::get('/meals/{id}/edit', [App\Http\Controllers\Gerant\MenuController::class, 'editMeal'])->name('meals.edit');
        Route::put('/meals/{id}', [App\Http\Controllers\Gerant\MenuController::class, 'updateMeal'])->name('meals.update');
        Route::delete('/meals/{id}', [App\Http\Controllers\Gerant\MenuController::class, 'deleteMeal'])->name('meals.delete');
        Route::get('/meals/{id}', [App\Http\Controllers\Gerant\MenuController::class, 'getMeal'])->name('meals.get');

        Route::get('/restaurant', [App\Http\Controllers\Gerant\RestaurantController::class, 'index'])->name('restaurant.index');
        Route::get('/restaurant/create', [App\Http\Controllers\Gerant\RestaurantController::class, 'create'])->name('restaurant.create');
        Route::post('/restaurant', [App\Http\Controllers\Gerant\RestaurantController::class, 'store'])->name('restaurant.store');
        Route::get('/restaurant/edit', [App\Http\Controllers\Gerant\RestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::put('/restaurant', [App\Http\Controllers\Gerant\RestaurantController::class, 'update'])->name('restaurant.update');
        Route::post('/restaurant/toggle-category', [App\Http\Controllers\Gerant\RestaurantController::class, 'toggleCategory'])->name('restaurant.toggle-category');

        Route::get('/tables', [App\Http\Controllers\Gerant\TableController::class, 'index'])->name('tables.index');
        Route::post('/tables', [App\Http\Controllers\Gerant\TableController::class, 'store'])->name('tables.store');
    });

    // Routes pour le client
    Route::middleware(['role:Client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', function () {return view('client.dashboard');  })->name('dashboard');
      
        Route::get('/profile', 'App\Http\Controllers\Client\ProfileController@index')->name('profile');
        Route::get('/profile/edit', 'App\Http\Controllers\Client\ProfileController@edit')->name('profile.edit');
        Route::put('/profile', 'App\Http\Controllers\Client\ProfileController@update')->name('profile.update');
        Route::delete('/profile/image', 'App\Http\Controllers\Client\ProfileController@deleteImage')->name('profile.delete_image');
        
        // Routes pour les réservations
        Route::get('/reservations/create', [App\Http\Controllers\Client\ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [App\Http\Controllers\Client\ReservationController::class, 'store'])->name('reservations.store');
        
        // Routes pour les avis
        Route::get('/reviews/create', [App\Http\Controllers\Client\ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [App\Http\Controllers\Client\ReviewController::class, 'store'])->name('reviews.store');
    });
});

Route::get('/reservation', function () {
    return redirect()->route('restaurants')->with('info', 'Veuillez choisir un restaurant pour effectuer une réservation.');
})->name('reservation');

// Routes pour vérifier les tables disponibles et les dates réservées
Route::post('/reservations/available-tables', [App\Http\Controllers\Client\ReservationController::class, 'getAvailableTables']);
Route::post('/reservations/booked-dates', [App\Http\Controllers\Client\ReservationController::class, 'getBookedDates']);