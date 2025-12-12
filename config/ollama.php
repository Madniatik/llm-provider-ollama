<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ollama Provider Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the Ollama LLM Provider Package.
    |
    */

    /**
     * Default API endpoint for Ollama
     */
    'api_endpoint' => env('OLLAMA_API_ENDPOINT', 'http://localhost:11434'),

    /**
     * Default model to use
     */
    'default_model' => env('OLLAMA_DEFAULT_MODEL', 'llama3.2:3b'),

    /**
     * Available models configured in this package
     */
    'available_models' => [
        'llama-3.3-70b',
        'llama-3.2-3b',
        'llama-3.1-8b',
        'mistral-7b',
        'codellama-70b',
        'deepseek-coder-6.7b',
        'gemma-2-27b',
        'gemma-2-9b',
        'phi-3-mini',
    ],

    /**
     * Default generation parameters
     */
    'defaults' => [
        'temperature' => 0.7,
        'top_p' => 0.9,
        'max_tokens' => 2000,
    ],

    /**
     * Enable/disable streaming support
     */
    'streaming' => true,

    /**
     * Enable/disable embeddings support
     */
    'embeddings' => true,

    /**
     * Provider capabilities
     */
    'capabilities' => [
        'streaming' => true,
        'embeddings' => true,
        'json_mode' => true,
        'vision' => false,
        'function_calling' => false,
    ],

    /**
     * Timeout settings (in seconds)
     */
    'timeout' => [
        'generate' => 120,
        'stream' => 120,
        'embed' => 30,
    ],
];
