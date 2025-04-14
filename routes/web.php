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


            Route::get('/profile', 'App\Http\Controllers\Admin\ProfileController@index')->name('admin.profile');
        Route::get('/profile/edit', 'App\Http\Controllers\Admin\ProfileController@edit')->name('admin.profile.edit');
        Route::put('/profile', 'App\Http\Controllers\Admin\ProfileController@update')->name('admin.profile.update');
        Route::delete('/profile/image', 'App\Http\Controllers\Admin\ProfileController@deleteImage')->name('admin.profile.delete_image');
        });
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
            
        });


    Route::middleware(['auth', 'role:Client'])->prefix('client')->group(function () {
        Route::get('/dashboard', function () {
            return view('client.dashboard');
        })->name('client.dashboard');
      
        Route::get('/profile', 'App\Http\Controllers\Client\ProfileController@index')->name('client.profile');
    Route::get('/profile/edit', 'App\Http\Controllers\Client\ProfileController@edit')->name('client.profile.edit');
    Route::put('/profile', 'App\Http\Controllers\Client\ProfileController@update')->name('client.profile.update');
    Route::delete('/profile/image', 'App\Http\Controllers\Client\ProfileController@deleteImage')->name('client.profile.delete_image');
    });
});