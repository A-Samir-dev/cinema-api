@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-trash text-danger me-2"></i>Trash Bin</h3>
        <p class="text-muted mb-0">Manage soft-deleted movies, restore them, or delete permanently.</p>
    </div>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Movies
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Poster</th>
                        <th>Title</th>
                        <th>Deleted At</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movies as $movie)
                        <tr>
                            <td class="ps-4">
                                @if($movie->image && !str_contains($movie->image, 'placeholder.com'))
                                    <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" width="45" height="65" class="rounded shadow-sm object-fit-cover">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 65px; font-size: 10px;">
                                        <i class="bi bi-image fs-5"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">{{ $movie->title }}</td>
                            <td><span class="text-muted small">{{ $movie->deleted_at->diffForHumans() }}</span></td>
                            <td class="text-end pe-4">
                                {{-- Restore Button --}}
                                <form action="{{ route('admin.movies.restore', $movie->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success me-1 px-3">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Restore
                                    </button>
                                </form>
                                
                                {{-- Force Delete Button --}}
                                <form action="{{ route('admin.movies.forceDelete', $movie->id) }}" method="POST" class="d-inline" onsubmit="return confirm('WARNING: This action cannot be undone. Permanently delete this movie?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger px-3">
                                        <i class="bi bi-x-circle me-1"></i> Delete Forever
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-trash3 fs-1 d-block mb-2 opacity-50"></i>
                                Trash bin is empty.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $movies->links() }}
</div>
@endsection