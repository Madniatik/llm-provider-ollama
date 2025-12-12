# Changelog

All notable changes to `bithoven/llm-provider-ollama` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1.0] - 2025-12-12

### Added
- Initial release of Ollama provider configurations
- 9 pre-configured models:
  - Llama 3.3 70B (general-purpose, large)
  - Llama 3.2 3B (lightweight, default)
  - Llama 3.1 8B (balanced)
  - Mistral 7B (efficient)
  - CodeLlama 70B (code expert)
  - Gemma 2 27B (Google, production)
  - Gemma 2 9B (Google, lightweight)
  - Phi-3 Mini (Microsoft, compact)
  - DeepSeek Coder 6.7B (code specialized)
- System prompt templates:
  - Default Assistant
  - Code Expert
  - Creative Writer
- Complete JSON schema with metadata
- Package manifest with model registry
- Hardware requirements documentation
- Installation and usage guide

### Configuration Details
- Optimized default parameters per model
- Context window specifications
- RAM and GPU requirements
- Streaming support enabled
- Hardware recommendations

### Documentation
- Comprehensive README with model selection guide
- Model comparison tables
- Troubleshooting section
- Resource links for each model family

[Unreleased]: https://github.com/bithoven/llm-provider-ollama/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/bithoven/llm-provider-ollama/releases/tag/v0.1.0
