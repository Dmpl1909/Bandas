<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------|
| Rotas Públicas                                                            |
|--------------------------------------------------------------------------|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('bands', BandController::class)->only(['index', 'show
', 'create', 'store']);

Route::get('/bands/{band}', [BandController::class, 'show'])->name('bands.show');




/*
|--------------------------------------------------------------------------|
| Rotas de Autenticação                                                     |
|--------------------------------------------------------------------------|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------|
| Rotas Protegidas (auth)                                                  |
|--------------------------------------------------------------------------|
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas explícitas para criar, guardar, editar, atualizar e deletar bandas
    Route::get('bands/create', [BandController::class, 'create'])->name('bands.create');
    Route::post('bands', [BandController::class, 'store'])->name('bands.store');
    Route::get('bands/{band}/edit', [BandController::class, 'edit'])->name('bands.edit');
    Route::put('bands/{band}', [BandController::class, 'update'])->name('bands.update');
    Route::delete('bands/{band}', [BandController::class, 'destroy'])->name('bands.destroy');




    // Exclusão permanente e restauração de bandas
    Route::delete('bands/{band}/force-delete', [BandController::class, 'forceDelete'])->name('bands.force-delete');
    Route::post('bands/{band}/restore', [BandController::class, 'restore'])->name('bands.restore');

    // Gerenciamento de usuários
    Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------|
| Rota de fallback para erros 404                                          |
|--------------------------------------------------------------------------|
*/
Route::fallback([ErrorController::class, 'error']);
