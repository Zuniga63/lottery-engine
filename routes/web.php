<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LotteryTicketController;
use App\Http\Controllers\SellerController;
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

  //Rutas para la administración de vendedores
  Route::get('/vendedores', [SellerController::class, 'index'])->name('sellers.index');

  //Rutas para la administración de clientes
  Route::get('/clientes', [CustomerController::class, 'index'])->name('customers.index');
  Route::get('/clientes/crear', [CustomerController::class, 'create'])->name('customers.create');
  Route::post('/clientes', [CustomerController::class, 'store'])->name('customers.store');
  Route::get('/clientes/{customer}', [CustomerController::class, 'show'])->name('customers.show');
  Route::get('/clientes/editar/{customer}', [CustomerController::class, 'edit'])->name('customers.edit');
  Route::put('/clientes/actualizar/{customer}', [CustomerController::class, 'update'])->name('customers.update');
  Route::delete('/clientes/eliminar/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

  //Rutas para la administración de boletos
  Route::get('/boletos', [LotteryTicketController::class, 'index'])->name('tickets.index');
  Route::get('/boletos/crear', [LotteryTicketController::class, 'create'])->name('tickets.create');
  Route::post('/boletos', [LotteryTicketController::class, 'store'])->name('tickets.store');
  Route::post('/boletos/abono', [LotteryTicketController::class, 'storePayment'])->name('tickets.payment');
  Route::get('/boletos/{lotteryTicket}', [LotteryTicketController::class, 'show'])->name('tickets.show');
  Route::delete('/boletos/eliminar/{lotteryTicket}', [LotteryTicketController::class, 'destroy'])->name('tickets.destroy');
  Route::delete('/boletos/eliminar-pago/{lotteryTicketPayment}', [LotteryTicketController::class, 'destroyPayment'])->name('tickets.destroyPayment');
});
