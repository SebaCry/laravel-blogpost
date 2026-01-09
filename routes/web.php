<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
| Estas rutas son accesibles sin autenticación
*/

// Página principal
Route::get('/', [PageController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Rutas de Blogs
|--------------------------------------------------------------------------
*/

// Listado de blogs
Route::get('blogs', [BlogController::class, 'index'])->name('blogs');

// Detalle de blog
Route::get('blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

/*
|--------------------------------------------------------------------------
| Rutas de Preguntas (Questions)
|--------------------------------------------------------------------------
*/

// Listado de preguntas
Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');

// Crear pregunta
Route::get('questions/create', [QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('questions', [QuestionController::class, 'store'])->name('questions.store')->middleware('auth');

// Editar pregunta
Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit')->middleware('auth');
Route::put('questions/{question}', [QuestionController::class, 'update'])
    ->name('questions.update')
    ->middleware('auth','can:update,question');

// Eliminar pregunta
Route::delete('questions/{question}', [QuestionController::class, 'destroy'])
    ->name('questions.destroy')
    ->middleware('auth', 'can:delete,question');

// Detalle de pregunta
Route::get('questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

/*
|--------------------------------------------------------------------------
| Rutas de Respuestas (Answers)
|--------------------------------------------------------------------------
*/

// Crear respuesta
Route::post('answers/{question}', [AnswerController::class, 'store'])->name('answers.store')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Autenticación Requerida)
|--------------------------------------------------------------------------
*/

// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Configuración de usuario
Route::middleware(['auth'])->group(function () {
    // Redirección principal de settings
    Route::redirect('settings', 'settings/profile');

    // Perfil de usuario
    Route::get('settings/profile', Profile::class)->name('profile.edit');

    // Contraseña
    Route::get('settings/password', Password::class)->name('user-password.edit');

    // Apariencia
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    // Autenticación de dos factores
    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
