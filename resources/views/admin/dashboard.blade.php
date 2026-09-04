@extends('admin.layout')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Welcome back, Admin! 👋</h3>
    <p class="text-muted mb-0">Here is a quick overview of your cinema management platform.</p>
</div>

{{-- Quick Stats Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase mb-1 opacity-75">Total Movies</h6>
                    <h2 class="fw-bold mb-0">{{ \App\Models\Movie::count() }}</h2>
                </div>
                <div class="fs-1 opacity-50">
                    <i class="bi bi-film"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase mb-1 opacity-75">Average Rating</h6>
                    <h2 class="fw-bold mb-0">{{ number_format(\App\Models\Movie::avg('rating') ?? 0, 1) }} ⭐</h2>
                </div>
                <div class="fs-1 opacity-50">
                    <i class="bi bi-star"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-dark text-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase mb-1 opacity-75">Quick Action</h6>
                    <a href="{{ route('admin.movies.create') }}" class="btn btn-sm btn-light text-dark fw-bold mt-2">
                        + Add New Movie
                    </a>
                </div>
                <div class="fs-1 opacity-50">
                    <i class="bi bi-plus-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Shortcut Card --}}
<div class="card p-4">
    <h5 class="fw-bold mb-3">System Shortcuts</h5>
    <div class="d-flex gap-3">
        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-collection-play me-1"></i> Manage All Movies
        </a>
        <a href="{{ route('admin.movies.create') }}" class="btn btn-outline-success">
            <i class="bi bi-plus-lg me-1"></i> Create Movie
        </a>
    </div>
</div>
@endsection