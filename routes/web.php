<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ShareController;
use App\Livewire\Dashboard;



Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/share/{slug}', [ShareController::class, 'show'])->name('share.show');
Route::get('/download/{file}', [ShareController::class, 'downloadFile'])->name('download.file');

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Redirect settings to profile
    Route::redirect('settings', 'settings/profile');

    // Settings Routes
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // File Management Routes
    Route::prefix('files')->name('files.')->group(function () {
        Route::post('/upload', [FileController::class, 'upload'])->name('upload');
        Route::get('/download/{id}', [FileController::class, 'show'])->name('download');
        Route::delete('/{id}', [FileController::class, 'delete'])->name('delete');
    });

    // File Sharing Routes
    Route::prefix('shares')->name('shares.')->group(function () {
        Route::post('/file/{id}', [ShareController::class, 'shareFile'])->name('file');
        Route::delete('/file/{id}', [ShareController::class, 'deleteSharedFile'])->name('delete');
    });
});

require __DIR__ . '/auth.php';
