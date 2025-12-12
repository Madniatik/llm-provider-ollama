<x-default-layout>
    @section('title', 'Ollama Connection Logs')
    @section('breadcrumbs')
        {{ Breadcrumbs::render('admin.ollama.logs') }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Connection History</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Timestamp</th>
                            <th>Endpoint</th>
                            <th>Model</th>
                            <th>Status</th>
                            <th>Response Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->connected_at }}</td>
                                <td>{{ $log->endpoint }}</td>
                                <td>{{ $log->model }}</td>
                                <td>
                                    <span class="badge badge-{{ $log->status === 'success' ? 'success' : 'danger' }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td>{{ $log->response_time_ms }} ms</td>
                                <td>
                                    <form action="{{ route('admin.ollama.logs.delete', $log->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this log?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No logs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $logs->links() }}
        </div>
    </div>
</x-default-layout>
