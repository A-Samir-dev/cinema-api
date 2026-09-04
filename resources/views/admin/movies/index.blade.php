@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Movie Management</h3>
        <p class="text-muted mb-0">Manage your movie catalog, update information, and modify details.</p>
    </div>
    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary px-4 py-2 rounded-3">
        <i class="bi bi-plus-lg me-1"></i> Add New Movie
    </a>
</div>

{{-- Success Alert --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Filter Card --}}
<div class="card mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.movies.index') }}" class="row g-3">
            {{-- Search Title --}}
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search by title..." value="{{ request('search') }}">
                </div>
            </div>

            {{-- Release Year --}}
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event text-muted"></i></span>
                    <input type="number" name="year" class="form-control bg-light border-start-0" placeholder="Release Year..." value="{{ request('year') }}">
                </div>
            </div>

            {{-- Minimum Rating --}}
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-star text-muted"></i></span>
                    <input type="number" step="0.1" min="0" max="10" name="rating" class="form-control bg-light border-start-0" placeholder="Min Rating (e.g. 7.0)..." value="{{ request('rating') }}">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100">Filter</button>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Movies Table Card --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Poster</th>
                        <th>Title</th>
                        <th>Release Year</th>
                        <th>Rating</th>
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
                            <td><span class="badge bg-light text-dark border">{{ $movie->release_year }}</span></td>
                            <td>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning px-2 py-1">
                                    <i class="bi bi-star-fill me-1"></i> {{ $movie->rating }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-outline-primary me-1 px-3">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to move this movie to trash?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                                        <i class="bi bi-trash me-1"></i> Trash
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-film fs-1 d-block mb-2"></i>
                                No movies found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination Links --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $movies->appends(request()->query())->links() }}
</div>
@endsection