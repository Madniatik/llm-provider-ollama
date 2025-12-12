<x-default-layout>
    @section('title', 'Ollama Settings')
    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin.ollama.settings') }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ollama Provider Settings</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.ollama.settings.update') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="form-label required">API Endpoint</label>
                    <input type="url" 
                           name="api_endpoint" 
                           class="form-control @error('api_endpoint') is-invalid @enderror" 
                           value="{{ old('api_endpoint', $settings['api_endpoint']) }}" 
                           required>
                    @error('api_endpoint')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="form-label required">Default Model</label>
                    <select name="default_model" class="form-select @error('default_model') is-invalid @enderror" required>
                        @foreach ($settings['available_models'] as $model)
                            <option value="{{ $model }}" {{ old('default_model', $settings['default_model']) === $model ? 'selected' : '' }}>
                                {{ $model }}
                            </option>
                        @endforeach
                    </select>
                    @error('default_model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="form-label required">Temperature</label>
                    <input type="number" 
                           name="temperature" 
                           class="form-control @error('temperature') is-invalid @enderror" 
                           value="{{ old('temperature', $settings['defaults']['temperature']) }}" 
                           min="0" 
                           max="2" 
                           step="0.1" 
                           required>
                    @error('temperature')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="form-label required">Max Tokens</label>
                    <input type="number" 
                           name="max_tokens" 
                           class="form-control @error('max_tokens') is-invalid @enderror" 
                           value="{{ old('max_tokens', $settings['defaults']['max_tokens']) }}" 
                           min="1" 
                           required>
                    @error('max_tokens')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
