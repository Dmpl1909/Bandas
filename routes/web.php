<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (acessíveis por todos)
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// Visualização pública de bandas
Route::resource('bands', BandController::class)->only(['index', 'show']);

// Visualização pública de álbuns (aninhados em bandas)
Route::resource('bands.albums', AlbumController::class)->only(['index', 'show']);

// Rotas independentes para álbuns (se necessário)
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação
|--------------------------------------------------------------------------
*/

// Rotas de login (acessíveis apenas para convidados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Rotas de registro
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout (acessível apenas para autenticados)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (requerem autenticação)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Rotas para Editores, Admins e Superadmins
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:editor,admin,superadmin'])->group(function () {
        // CRUD completo para bandas (exceto visualização pública)
        Route::resource('bands', BandController::class)->except(['index', 'show',]);

        // CRUD completo para álbuns aninhados (exceto visualização pública)
        Route::resource('bands.albums', AlbumController::class)->except(['index', 'show']);

        // CRUD independente para álbuns
        Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
        Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
        Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
        Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
        Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas para Admins e Superadmins
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,superadmin'])->group(function () {
        // Exclusão permanente de bandas
        Route::delete('bands/{band}/force-delete', [BandController::class, 'forceDelete'])->name('bands.force-delete');

        // Restauração de bandas excluídas
        Route::post('bands/{band}/restore', [BandController::class, 'restore'])->name('bands.restore');
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas Exclusivas para Superadmin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:superadmin'])->group(function () {
        // Gerenciamento de usuários
        Route::resource('users', UserController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Rota de Fallback para Erros 404
|--------------------------------------------------------------------------
*/
Route::fallback([ErrorController::class, 'error']);
