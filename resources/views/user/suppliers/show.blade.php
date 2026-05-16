@extends('layouts.main')

@section('title', $supplier->company_name . ' | Supplier Profile')

@section('content')
<div class="mb-4">
    <a href="{{ route('user.suppliers.index') }}" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i> Back to Suppliers
    </a>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="custom-card p-4 text-center">
            <div class="mb-4">
                <div class="avatar-lg mx-auto bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                    <span class="display-6 fw-bold text-primary">{{ substr($supplier->company_name, 0, 1) }}</span>
                </div>
                <h3 class="fw-bold mb-1">{{ $supplier->company_name }}</h3>
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <div class="text-warning me-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= round($supplier->average_rating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                    <span class="text-muted">({{ $supplier->rating_count }} reviews)</span>
                </div>
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Verified Supplier</span>
            </div>

            <hr class="border-secondary border-opacity-25 my-4">

            <div class="text-start">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Contact Information</h6>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-person text-primary me-3"></i>
                    <div>
                        <small class="text-muted d-block">Contact Person</small>
                        <span>{{ $supplier->name }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-envelope text-primary me-3"></i>
                    <div>
                        <small class="text-muted d-block">Email Address</small>
                        <span>{{ $supplier->email }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-telephone text-primary me-3"></i>
                    <div>
                        <small class="text-muted d-block">Phone Number</small>
                        <span>{{ $supplier->phone }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-geo-alt text-primary me-3"></i>
                    <div>
                        <small class="text-muted d-block">Business Address</small>
                        <span>{{ $supplier->address }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('user.requests.create', ['supplier_id' => $supplier->id]) }}" class="btn btn-primary-custom w-100">
                    <i class="bi bi-plus-lg me-2"></i> Create New Request
                </a>
            </div>
        </div>
    </div>

    <!-- Feedback & History -->
    <div class="col-lg-8">
        <div class="custom-card p-4 h-100">
            <h4 class="fw-bold mb-4">Customer Satisfaction & Feedback</h4>
            
            <div class="row g-4 mb-5">
                <div class="col-md-4 text-center">
                    <div class="p-3 bg-dark bg-opacity-25 rounded border border-secondary border-opacity-25">
                        <h2 class="fw-bold text-warning mb-0">{{ number_format($supplier->average_rating, 1) }}</h2>
                        <small class="text-muted">Avg. Rating</small>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-3 bg-dark bg-opacity-25 rounded border border-secondary border-opacity-25">
                        <h2 class="fw-bold text-success mb-0">100%</h2>
                        <small class="text-muted">On-Time Delivery</small>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-3 bg-dark bg-opacity-25 rounded border border-secondary border-opacity-25">
                        <h2 class="fw-bold text-info mb-0">{{ $supplier->rating_count }}</h2>
                        <small class="text-muted">Total Reviews</small>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Recent Reviews</h5>
            @forelse($feedbacks as $feedback)
                <div class="p-4 bg-dark bg-opacity-25 rounded border border-secondary border-opacity-10 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-secondary bg-opacity-25 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-person text-muted"></i>
                            </div>
                            <span class="fw-medium">{{ $feedback->user->name ?? 'Anonymous Customer' }}</span>
                        </div>
                        <div class="text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $feedback->customer_rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-muted mb-0 fst-italic">"{{ $feedback->customer_feedback ?? 'No written comment provided.' }}"</p>
                    <div class="mt-2">
                        <small class="text-muted text-sm">{{ $feedback->created_at->format('M d, Y') }}</small>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-chat-left-dots display-4 text-muted mb-3 d-block"></i>
                    <p class="text-muted">No reviews yet for this supplier.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
