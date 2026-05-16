@extends('layouts.main')

@section('title', 'Add Article')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.knowledge-base.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Back to Knowledge Base
    </a>
    <h2 class="brand-font mb-1">Create New Article</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="custom-card p-4">
            <form action="{{ route('admin.knowledge-base.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-muted">Article Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted">Content <span class="text-danger">*</span></label>
                    <textarea name="content" rows="10" class="form-control bg-dark text-white border-secondary" required></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary-custom px-4">Publish Article</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
