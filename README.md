# Bithoven LLM Provider - Ollama

[![Latest Version](https://img.shields.io/packagist/v/bithoven/llm-provider-ollama)](https://packagist.org/packages/bithoven/llm-provider-ollama)
[![License](https://img.shields.io/packagist/l/bithoven/llm-provider-ollama)](LICENSE)

Pre-configured Ollama model settings for [Bithoven LLM Manager](https://github.com/bithoven/bithoven-extension-llm-manager). This package provides optimized configurations for running powerful open-source LLMs locally with privacy and zero API costs.

## 🎯 Features

- **9 Recommended Models** - Pre-configured for optimal performance
- **Privacy-First** - All models run locally, no data sent to external APIs
- **Zero Cost** - No per-token charges, unlimited usage
- **Optimized Parameters** - Tested settings for each model
- **System Prompts** - Ready-to-use templates for different use cases
- **Hardware Guidance** - Clear requirements for each model

## 📦 Included Models

### General Purpose

| Model | Size | RAM | Best For | Default |
|-------|------|-----|----------|---------|
| **Llama 3.3 70B** | 40GB | 64GB | Complex reasoning, long-form content | ❌ |
| **Llama 3.1 8B** | 4.7GB | 16GB | Balanced performance, everyday tasks | ❌ |
| **Llama 3.2 3B** | 2GB | 8GB | Fast responses, resource-efficient | ✅ |
| **Mistral 7B** | 4.1GB | 12GB | Efficient, production-ready | ❌ |

### Code Specialized

| Model | Size | RAM | Best For |
|-------|------|-----|----------|
| **CodeLlama 70B** | 39GB | 64GB | Expert code generation, refactoring |
| **DeepSeek Coder 6.7B** | 3.8GB | 10GB | Code completion, bug detection |

### Google Gemma Series

| Model | Size | RAM | Best For |
|-------|------|-----|----------|
| **Gemma 2 27B** | 16GB | 32GB | Production chatbots, reasoning |
| **Gemma 2 9B** | 5.4GB | 12GB | Fast, efficient, everyday tasks |

### Microsoft Phi Series

| Model | Size | RAM | Best For |
|-------|------|-----|----------|
| **Phi-3 Mini** | 2.3GB | 8GB | Edge deployments, mobile apps |

## 🚀 Installation

### Prerequisites

1. **Ollama Installed** - [Install Ollama](https://ollama.ai/download)
2. **LLM Manager Extension** - Install via Extension Manager

```bash
# Step 1: Install LLM Manager (if not already installed)
php artisan bithoven:extension:install llm-manager

# Step 2: Install this package
composer require bithoven/llm-provider-ollama

# Step 3: Pull models from Ollama
ollama pull llama3.2:3b        # Default (2GB)
ollama pull llama3.1:8b        # Balanced (4.7GB)
ollama pull mistral:7b         # Efficient (4.1GB)
ollama pull gemma2:9b          # Fast Google (5.4GB)

# Step 4: Import configurations
php artisan llm:import ollama

✅ Success! 9 Ollama configurations imported
```

## 📖 Usage

### Basic Import

```bash
# Import all Ollama configurations
php artisan llm:import ollama

# Import specific models only
php artisan llm:import ollama --only=llama-3.2-3b,mistral-7b

# Preview without importing
php artisan llm:import ollama --dry-run
```

### List Available Packages

```bash
php artisan llm:packages

# Output:
# Available Provider Packages:
#   ✓ ollama - 9 configurations (installed)
#   - openai - 10 configurations
#   - anthropic - 5 configurations
```

### Using Imported Configurations

Once imported, configurations are available throughout LLM Manager:

1. **Quick Chat** - Select imported models from dropdown
2. **Conversations** - Use for multi-turn chat sessions
3. **Knowledge Base** - RAG queries with local models
4. **API Endpoints** - Programmatic access via REST API

## 🎨 System Prompts

Included templates in `prompts/system/`:

- **default-assistant.txt** - Helpful, safe, honest responses
- **code-expert.txt** - Expert software engineering assistance
- **creative-writer.txt** - Storytelling and creative content

## 🔧 Configuration Details

### Model Selection Guide

**Choose Llama 3.2 3B if:**
- You need fast responses
- Limited GPU/RAM (4-8GB)
- Prototyping or testing
- Basic Q&A and chat

**Choose Llama 3.1 8B if:**
- Balanced quality/performance
- Mid-range hardware (16GB RAM)
- Code assistance needed
- General-purpose tasks

**Choose Mistral 7B if:**
- Production chatbot
- Instruction-following critical
- Efficient performance needed
- 8-12GB RAM available

**Choose CodeLlama 70B if:**
- Code generation is primary use
- Complex refactoring tasks
- Have high-end hardware (64GB+ RAM)
- Need expert-level code quality

## ⚙️ Advanced Configuration

### Custom Parameters

After import, you can customize any configuration via LLM Manager UI:

1. Navigate to **Settings → LLM Configurations**
2. Find the imported configuration
3. Click **Edit**
4. Adjust parameters (temperature, max_tokens, etc.)
5. Save changes

### Adding New Models

Create a new JSON file in your app:

```json
{
    "version": "0.1.0",
    "configuration": {
        "name": "Custom Llama Fine-tune",
        "slug": "custom-llama",
        "provider_id": 1,
        "model_name": "my-custom-model:latest",
        "api_endpoint": "http://localhost:11434/api/chat",
        "default_parameters": {
            "temperature": 0.7,
            "top_p": 0.9
        }
    }
}
```

Import manually:
```bash
php artisan llm:import --file=/path/to/custom-model.json
```

## 🛠️ Troubleshooting

### Ollama Not Running

```bash
# Check Ollama status
curl http://localhost:11434/api/version

# Start Ollama
ollama serve
```

### Model Not Found

```bash
# List available models
ollama list

# Pull missing model
ollama pull llama3.2:3b
```

### Out of Memory

If model fails to load:
1. Close other applications
2. Use a smaller model (3B instead of 8B)
3. Check available RAM: `free -h` (Linux) or Activity Monitor (Mac)
4. Consider GPU offloading if available

## 📚 Resources

- **Ollama Documentation**: https://ollama.ai/docs
- **Model Library**: https://ollama.ai/library
- **LLM Manager Guide**: https://github.com/bithoven/bithoven-extension-llm-manager
- **Model Cards**:
  - [Llama 3.3](https://ai.meta.com/llama)
  - [Mistral](https://mistral.ai/)
  - [Gemma](https://ai.google.dev/gemma)
  - [Phi-3](https://azure.microsoft.com/en-us/products/phi-3)
  - [CodeLlama](https://ai.meta.com/blog/code-llama-large-language-model-coding/)
  - [DeepSeek](https://github.com/deepseek-ai/DeepSeek-Coder)

## 🤝 Contributing

Contributions welcome! To add new models:

1. Fork the repository
2. Create config file following the schema
3. Test with LLM Manager
4. Submit PR with model details

## 📄 License

MIT License - see [LICENSE](LICENSE) file for details.

## 🆘 Support

- **Issues**: [GitHub Issues](https://github.com/bithoven/llm-provider-ollama/issues)
- **Discussions**: [GitHub Discussions](https://github.com/bithoven/llm-provider-ollama/discussions)
- **Discord**: [Bithoven Community](https://discord.gg/bithoven)

---

**Made with ❤️ by the Bithoven Team**
