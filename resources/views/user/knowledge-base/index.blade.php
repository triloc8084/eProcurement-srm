@extends('layouts.main')

@section('title', 'Knowledge Base')

@section('content')
<div class="mb-5 text-center">
    <h1 class="brand-font display-5 mb-3">Knowledge Base</h1>
    <p class="text-muted lead mx-auto" style="max-width: 600px;">Browse procurement policies, guidelines, and training materials.</p>
</div>
<div class="row justify-content-center mb-5">
    <div class="col-md-6">
        <form action="{{ route('user.knowledge-base.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control bg-dark text-white border-secondary rounded-pill px-4" placeholder="Search articles or keywords..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary-custom rounded-pill px-4">Search</button>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($articles as $article)
    <div class="col-md-4">
        <div class="custom-card p-4 h-100 d-flex flex-column">
            <div class="mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">Policy & Guide</span>
                <h4 class="fw-bold">{{ $article->title }}</h4>
            </div>
            <p class="text-muted flex-grow-1">{{ Str::limit($article->content, 120) }}</p>
            <div class="mt-4 pt-3 border-top border-secondary" style="border-color: var(--glass-border) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted"><i class="bi bi-clock me-1"></i> {{ $article->created_at->diffForHumans() }}</small>
                    <a href="{{ route('user.knowledge-base.show', $article) }}" class="text-primary text-decoration-none fw-medium">Read More <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="bi bi-journal-x display-1 text-muted mb-3 d-block"></i>
        <h4 class="text-muted">No articles found</h4>
        <p class="text-muted">Check back later for updates to the knowledge base.</p>
    </div>
    @endforelse
</div>

<div class="mt-5">
    {{ $articles->links('pagination::bootstrap-5') }}
</div>
@endsection
