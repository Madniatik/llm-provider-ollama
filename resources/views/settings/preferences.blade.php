<x-default-layout>
    @section('title', 'Ollama Preferences')
    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin.ollama.preferences') }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Ollama Preferences</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.ollama.preferences.update') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="form-label">Preferred Model</label>
                    <input type="text" 
                           name="preferred_model" 
                           class="form-control" 
                           value="{{ old('preferred_model', $preferences->preferred_model ?? '') }}" 
                           placeholder="e.g., llama3.2:3b">
                </div>

                <div class="mb-5">
                    <label class="form-label">Custom API Endpoint</label>
                    <input type="url" 
                           name="api_endpoint" 
                           class="form-control" 
                           value="{{ old('api_endpoint', $preferences->api_endpoint ?? '') }}" 
                           placeholder="http://localhost:11434">
                </div>

                <div class="mb-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="auto_sync" 
                               id="auto_sync" 
                               value="1" 
                               {{ old('auto_sync', $preferences->auto_sync ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="auto_sync">
                            Auto-sync models from Ollama server
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Preferences</button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
