<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ollama Provider API Routes
|--------------------------------------------------------------------------
|
| API endpoints for Ollama provider (if needed for OAuth or webhooks).
|
*/

Route::middleware(['api'])->prefix('api/ollama')->group(function () {
    // Future: OAuth callbacks, webhooks, etc.
    // Route::post('/webhook', [OllamaWebhookController::class, 'handle']);
});
