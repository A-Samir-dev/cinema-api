@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Movie: {{ $movie->title }}</h3>
        <p class="text-muted mb-0">Update movie details and click save changes.</p>
    </div>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Movie Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $movie->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Release Year</label>
                    <input type="number" name="release_year" class="form-control @error('release_year') is-invalid @enderror" value="{{ old('release_year', $movie->release_year) }}">
                    @error('release_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Rating (0 to 10)</label>
                    <input type="number" step="0.1" name="rating" class="form-control @error('rating') is-invalid @enderror" value="{{ old('rating', $movie->rating) }}">
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $movie->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Poster Image</label>
                    @if($movie->image && !str_contains($movie->image, 'placeholder.com'))
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $movie->image) }}" alt="Current Poster" width="70" class="rounded shadow-sm">
                            <span class="text-muted ms-2 small">Current Image</span>
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Leave empty if you don't want to change the image.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 text-end mt-4">
                    <button type="submit" class="btn btn-warning text-dark px-5 py-2 fw-bold">Update Movie</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">🤖 AI Movie Insight</h5>
        <button id="generate-ai-btn" type="button" class="btn btn-primary btn-sm" onclick="fetchAiReview({{ $movie->id }})">
            توليد ملخص الـ AI
        </button>
    </div>
    <div class="card-body">
        <div id="ai-loading" class="d-none text-muted mb-2">
            <span>جاري تحليل الفيلم واستخراج الملخص بواسطة Gemini AI... ⏳</span>
        </div>
        <p id="ai-review-text" class="card-text text-secondary">
            اضغط على الزرار أعلاه لتوليد مراجعة ملخصة للفيلم باستخدام Gemini AI.
        </p>
    </div>
</div>

<script>
function fetchAiReview(movieId) {
    const btn = document.getElementById('generate-ai-btn');
    const loading = document.getElementById('ai-loading');
    const reviewText = document.getElementById('ai-review-text');

    btn.disabled = true;
    loading.classList.remove('d-none');
    reviewText.innerText = '';

    fetch(`/admin/movies/${movieId}/ai-review`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        loading.classList.add('d-none');
        btn.disabled = false;
        if (data.status) {
            reviewText.innerHTML = `<strong>Review:</strong> ${data.ai_review}`;
        } else {
            reviewText.innerText = data.ai_review || data.message || 'حدث خطأ أثناء الجلب.';
        }
    })
    .catch(error => {
        loading.classList.add('d-none');
        btn.disabled = false;
        reviewText.innerText = 'تعذر الاتصال بالسيرفر: ' + error.message;
    });
}
</script>
@endsection