<?php

namespace Bithoven\LLMProviderOllama\Services;

use Bithoven\LLMManager\Contracts\LLMProviderInterface;
use Bithoven\LLMManager\Models\LLMProviderConfiguration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class OllamaProvider implements LLMProviderInterface
{
    public function __construct(protected LLMProviderConfiguration $configuration)
    {
    }

    public function generate(string $prompt, array $parameters = []): array
    {
        $endpoint = rtrim($this->configuration->api_endpoint, '/') . '/api/generate';
        
        $response = Http::timeout(120)
            ->post($endpoint, [
                'model' => $this->configuration->model,
                'prompt' => $prompt,
                'stream' => false,
                'options' => [
                    'temperature' => (float) ($parameters['temperature'] ?? 0.7),
                    'top_p' => (float) ($parameters['top_p'] ?? 0.9),
                    'num_predict' => (int) ($parameters['max_tokens'] ?? 2000),
                ],
            ]);

        if (!$response->successful()) {
            throw new \Exception("Ollama API error: {$response->body()}");
        }

        $data = $response->json();

        return [
            'response' => $data['response'] ?? '',
            'usage' => [
                'prompt_tokens' => $data['prompt_eval_count'] ?? 0,
                'completion_tokens' => $data['eval_count'] ?? 0,
                'total_tokens' => ($data['prompt_eval_count'] ?? 0) + ($data['eval_count'] ?? 0),
            ],
            'model' => $this->configuration->model,
        ];
    }

    public function embed(string|array $text): array
    {
        $endpoint = rtrim($this->configuration->api_endpoint, '/') . '/api/embeddings';

        $response = Http::timeout(30)
            ->post($endpoint, [
                'model' => $this->configuration->model,
                'prompt' => is_array($text) ? implode(' ', $text) : $text,
            ]);

        if (!$response->successful()) {
            throw new \Exception("Ollama Embeddings API error: {$response->body()}");
        }

        return $response->json('embedding', []);
    }

    public function stream(string $prompt, array $context, array $parameters, callable $callback): array
    {
        // Ollama streaming endpoint
        $endpoint = rtrim($this->configuration->api_endpoint, '/') . '/api/generate';

        // Build context if provided (for multi-turn conversations)
        $systemPrompt = '';
        if (!empty($context)) {
            $contextText = Collection::make($context)
                ->map(fn($msg) => "{$msg['role']}: {$msg['content']}")
                ->join("\n");
            $systemPrompt = "Previous conversation:\n{$contextText}\n\n";
        }

        $fullPrompt = $systemPrompt . "user: {$prompt}";

        // Prepare request payload
        $payload = json_encode([
            'model' => $this->configuration->model,
            'prompt' => $fullPrompt,
            'stream' => true,
            'options' => [
                'temperature' => (float) ($parameters['temperature'] ?? 0.7),
                'top_p' => (float) ($parameters['top_p'] ?? 0.9),
                'num_predict' => (int) ($parameters['max_tokens'] ?? 2000),
            ],
        ]);

        // Initialize streaming HTTP request
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_WRITEFUNCTION => function ($curl, $data) use ($callback) {
                $lines = explode("\n", $data);
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) {
                        continue;
                    }

                    $chunk = json_decode($line, true);
                    if (!$chunk) {
                        continue;
                    }

                    // Extract response content
                    if (isset($chunk['response']) && !empty($chunk['response'])) {
                        $callback($chunk['response']);
                    }

                    // Stop on completion
                    if (isset($chunk['done']) && $chunk['done'] === true) {
                        return strlen($data);
                    }
                }

                return strlen($data);
            },
            CURLOPT_TIMEOUT => 120,
        ]);

        // Execute streaming request
        $promptTokens = 0;
        $completionTokens = 0;
        $finishReason = 'stop';

        if (!curl_exec($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Ollama streaming error: {$error}");
        }

        // Make final request to get token counts
        $finalResponse = Http::timeout(5)->post($endpoint, [
            'model' => $this->configuration->model,
            'prompt' => $fullPrompt,
            'stream' => false,
        ]);

        if ($finalResponse->successful()) {
            $data = $finalResponse->json();
            $promptTokens = $data['prompt_eval_count'] ?? 0;
            $completionTokens = $data['eval_count'] ?? 0;
        }

        curl_close($ch);

        return [
            'usage' => [
                'prompt_tokens' => $promptTokens,
                'completion_tokens' => $completionTokens,
                'total_tokens' => $promptTokens + $completionTokens,
            ],
            'model' => $this->configuration->model,
            'finish_reason' => $finishReason,
        ];
    }

    public function supports(string $feature): bool
    {
        $supportedFeatures = [
            'streaming' => true,
            'embeddings' => true,
            'json_mode' => true,
        ];

        return $supportedFeatures[$feature] ?? false;
    }
}
