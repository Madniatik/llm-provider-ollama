<?php

namespace Bithoven\LLMProviderOllama;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Bithoven\LLMProviderOllama\Services\OllamaProvider;
use Bithoven\LLMManager\Models\LLMProviderConfiguration;

/**
 * Ollama Provider Service Provider
 * 
 * Registers Ollama provider with LLM Manager system
 * 
 * @package Bithoven\LLMProviderOllama
 * @version 0.2.0
 */
class OllamaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/ollama.php',
            'llm-providers.ollama'
        );

        // Register Ollama provider (bound when needed with configuration)
        $this->app->bind(OllamaProvider::class, function ($app) {
            // This will be resolved with proper configuration when needed
            return $app->make(OllamaProvider::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ollama');

        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/ollama.php' => \config_path('llm-providers/ollama.php'),
        ], 'ollama-config');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => \resource_path('views/vendor/ollama'),
        ], 'ollama-views');

        // Publish assets
        $this->publishes([
            __DIR__ . '/../public' => \public_path('vendor/ollama'),
        ], 'ollama-assets');

        // Register commands
        if ($this->app->runningInConsole()) {
            // Commands can be added here
        }
    }
}
