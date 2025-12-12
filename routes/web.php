<?php

use Illuminate\Support\Facades\Route;
use Bithoven\LLMProviderOllama\Http\Controllers\OllamaSettingsController;

/*
|--------------------------------------------------------------------------
| Ollama Provider Web Routes
|--------------------------------------------------------------------------
|
| Admin routes for Ollama provider settings and management.
|
*/

Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    // Ollama Settings (Admin)
    Route::prefix('ollama')->name('admin.ollama.')->group(function () {
        Route::get('/settings', [OllamaSettingsController::class, 'index'])
            ->name('settings')
            ->middleware('permission:ollama.manage');

        Route::post('/settings', [OllamaSettingsController::class, 'update'])
            ->name('settings.update')
            ->middleware('permission:ollama.manage');

        // User Preferences
        Route::get('/preferences', [OllamaSettingsController::class, 'preferences'])
            ->name('preferences')
            ->middleware('permission:ollama.preferences');

        Route::post('/preferences', [OllamaSettingsController::class, 'updatePreferences'])
            ->name('preferences.update')
            ->middleware('permission:ollama.preferences');

        // Connection Logs
        Route::get('/logs', [OllamaSettingsController::class, 'logs'])
            ->name('logs')
            ->middleware('permission:ollama.logs.view');

        Route::delete('/logs/{id}', [OllamaSettingsController::class, 'deleteLog'])
            ->name('logs.delete')
            ->middleware('permission:ollama.logs.delete');
    });
});
