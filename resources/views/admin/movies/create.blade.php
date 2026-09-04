@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Add New Movie</h3>
        <p class="text-muted mb-0">Enter movie details to publish it to your platform.</p>
    </div>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Movie Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Inception">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Release Year</label>
                    <input type="number" name="release_year" class="form-control @error('release_year') is-invalid @enderror" value="{{ old('release_year') }}" placeholder="e.g. 2010">
                    @error('release_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Rating (0 to 10)</label>
                    <input type="number" step="0.1" name="rating" class="form-control @error('rating') is-invalid @enderror" value="{{ old('rating') }}" placeholder="e.g. 8.8">
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Movie storyline...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Poster Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Save Movie</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection