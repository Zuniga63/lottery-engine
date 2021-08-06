<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard', 301);

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
  //DASHBOARD
  Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
  })->name('dashboard');

  // RUTAS PARA LA ADMINISTRACIÓN DE USUARIOS
  Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
  Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
  Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])
    ->whereNumber('id')
    ->name('users.destroy');

  
});
