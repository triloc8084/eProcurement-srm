@extends('layouts.main')

@section('title', $knowledgeBase->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('user.knowledge-base.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Back to Knowledge Base
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="custom-card p-5">
            <h1 class="brand-font fw-bold mb-3">{{ $knowledgeBase->title }}</h1>
            <div class="d-flex align-items-center mb-5 pb-4 border-bottom border-secondary" style="border-color: var(--glass-border) !important;">
                <div class="text-muted me-4"><i class="bi bi-calendar3 me-2"></i> Published: {{ $knowledgeBase->created_at->format('M d, Y') }}</div>
                <div class="text-muted"><i class="bi bi-person me-2"></i> Admin Team</div>
            </div>
            
            <div class="article-content fs-5" style="line-height: 1.8; color: #e2e8f0;">
                {!! nl2br(e($knowledgeBase->content)) !!}
            </div>
            
            @if($knowledgeBase->document_path)
            <div class="mt-5 pt-4 border-top border-secondary" style="border-color: var(--glass-border) !important;">
                <h5 class="mb-3">Attachments</h5>
                <a href="#" class="btn btn-outline-light d-inline-flex align-items-center">
                    <i class="bi bi-file-earmark-pdf fs-4 me-2 text-danger"></i>
                    <div>
                        <div class="fw-medium">Download Document</div>
                        <small class="text-muted">PDF File</small>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
