<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Models\Chirp;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//fetching Welcome.vue page and also passing several objects keys and value - 'canLogin', 'canRegister', etc. Into Welcome.vue
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//menggunakan middleware, jika sudah 'auth' dan 'verified' maka route /dashboard akan render Dashboard.vue
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

//multi roles auth

Route::get('/admin', function () {
    return Inertia::render('Roles/Admin/Admin');
})->middleware(['auth', 'verified', 'admin'])->name('admin');

Route::get('/eventadmin', function () {
    return Inertia::render('Roles/EventAdmin/EventAdmin');
})->middleware(['auth', 'verified', 'eventadmin'])->name('eventadmin');

//default breeze package

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ------------------------------------------------------------------------------------------------------------------------
//  Chirp Model 
// ------------------------------------------------------------------------------------------------------------------------
Route::resource('chirps', ChirpController::class)
    ->only(['index','store','update','destroy'])
    ->middleware(['auth','verified']);

//resource route similar to (the '->only()') :
// Route::get('/chirps', [ChirpController::class, 'index'])->name('chirps.index');
// Route::post('/chirps', [ChirpController::class, 'store'])->name('chirps.store');

//Route::middleware('auth')->group(function()...); => berarti route tersebut hanya bisa diakses jika sudah ter authentikasi
//Route::http_request_bebas('/route_bebas', BebasController::class)->middleware('auth'); => maknanya sama

require __DIR__.'/auth.php';

// ------------------------------------------------------------------------------------------------------------------------
// -> Multi auth routes list
// ------------------------------------------------------------------------------------------------------------------------

// Route::middleware(['auth', 'user-access:user'])->group(function () {
  
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
// });

// Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
//     Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
// });

// Route::middleware(['auth', 'user-access:manager'])->group(function () {
  
//     Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
// });
