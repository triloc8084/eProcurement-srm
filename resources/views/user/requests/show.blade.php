@extends('layouts.main')

@section('title', 'Request Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('user.requests.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Back to My Requests
    </a>
    <h2 class="brand-font mb-1">Request: {{ $request->title }}</h2>
    <p class="text-muted mb-0">Submitted on {{ $request->created_at->format('M d, Y') }}</p>
</div>

<!-- Progress Stepper -->
<div class="custom-card p-5 mb-4">
    <div class="stepper">
        <div class="step {{ $request->status !== 'rejected' ? 'completed' : '' }}">
            <div class="step-icon"><i class="bi bi-file-earmark-plus"></i></div>
            <div class="step-label">Submitted</div>
        </div>
        <div class="step {{ $request->status === 'pending' ? 'active' : ($request->status !== 'rejected' ? 'completed' : '') }}">
            <div class="step-icon"><i class="bi bi-search"></i></div>
            <div class="step-label">Reviewing</div>
        </div>
        <div class="step {{ $request->status === 'approved' ? 'active' : ($request->status === 'completed' ? 'completed' : '') }}">
            <div class="step-icon"><i class="bi bi-check2-square"></i></div>
            <div class="step-label">Approved</div>
        </div>
        <div class="step {{ $request->status === 'completed' ? 'active completed' : '' }}">
            <div class="step-icon"><i class="bi bi-flag"></i></div>
            <div class="step-label">Finalized</div>
        </div>
    </div>
</div>


<!-- Tabs Navigation -->
<ul class="nav nav-pills mb-4 gap-2 fade-in-up delay-100" id="requestTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active px-4 py-2 rounded-pill fw-bold border border-secondary border-opacity-10" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab">
            <i class="bi bi-info-circle me-2"></i> Overview
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link px-4 py-2 rounded-pill fw-bold border border-secondary border-opacity-10" id="discussion-tab" data-bs-toggle="pill" data-bs-target="#discussion" type="button" role="tab">
            <i class="bi bi-chat-dots me-2"></i> Discussion
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link px-4 py-2 rounded-pill fw-bold border border-secondary border-opacity-10" id="history-tab" data-bs-toggle="pill" data-bs-target="#history" type="button" role="tab">
            <i class="bi bi-clock-history me-2"></i> Status History
        </button>
    </li>
</ul>

<div class="tab-content fade-in-up delay-200" id="requestTabsContent">
    <!-- Tab 1: Overview -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="custom-card p-4 mb-4">
                    <h5 class="mb-4 border-bottom border-secondary pb-3">Request Specifications</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1 small uppercase fw-bold">Preferred Supplier</h6>
                            <p class="fs-5 fw-bold">{{ $request->supplier->company_name ?? 'No Preference' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1 small uppercase fw-bold">Final Budget</h6>
                            <p class="fs-5 fw-bold text-success">{{ $request->budget ? '$'.number_format($request->budget, 2) : 'TBD' }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-1 small uppercase fw-bold">Description</h6>
                        <div class="p-3 bg-dark bg-opacity-25 rounded border border-secondary border-opacity-25">
                            {!! nl2br(e($request->description)) !!}
                        </div>
                    </div>

                    @if($request->attachment_path)
                    <div class="p-3 bg-primary bg-opacity-5 rounded d-flex align-items-center justify-content-between border border-primary border-opacity-10">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-pdf fs-3 text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Supporting Document</h6>
                                <small class="text-muted">Attached by Customer</small>
                            </div>
                        </div>
                        <a href="{{ Storage::url($request->attachment_path) }}" target="_blank" class="btn btn-primary-custom btn-sm rounded-pill">
                            <i class="bi bi-download me-1"></i> View
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="custom-card p-4">
                    <h5 class="mb-4 border-bottom border-secondary pb-3 text-center">Status Action</h5>
                    <div class="text-center py-2">
                        @if($request->status === 'pending')
                            <div class="display-3 text-warning mb-3"><i class="bi bi-hourglass-split"></i></div>
                            <h4 class="text-warning">Pending Review</h4>
                            <p class="text-muted small">Awaiting supplier confirmation.</p>
                        @elseif($request->status === 'approved')
                            <div class="display-3 text-success mb-3"><i class="bi bi-check-circle"></i></div>
                            <h4 class="text-success">Approved</h4>
                            <form action="{{ route('user.requests.sign', $request) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="form-check text-start mb-3 p-2 bg-dark bg-opacity-25 rounded small">
                                    <input class="form-check-input ms-0" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label ms-2" for="termsCheck">I agree to terms</label>
                                </div>
                                <button type="submit" class="btn btn-primary-custom w-100">Sign & Finalize</button>
                            </form>
                        @elseif($request->status === 'completed')
                            <div class="display-3 text-primary mb-3"><i class="bi bi-flag-fill"></i></div>
                            <h4 class="text-primary">Completed</h4>
                            @if(!$request->customer_rating)
                                <button class="btn btn-outline-primary btn-sm mt-3 rounded-pill" onclick="document.getElementById('discussion-tab').click()">Leave Rating</button>
                            @endif
                        @else
                            <div class="display-3 text-danger mb-3"><i class="bi bi-x-circle"></i></div>
                            <h4 class="text-danger">Rejected</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2: Discussion -->
    <div class="tab-pane fade" id="discussion" role="tabpanel">
        <div class="row">
            <div class="col-lg-8">
                @include('partials.chat', ['procurement' => $request])
            </div>
            <div class="col-lg-4">
                @if($request->status === 'completed' && !$request->customer_rating)
                <div class="custom-card p-4">
                    <h5 class="mb-3 fw-bold border-bottom border-secondary pb-3">Feedback Required</h5>
                    <form action="{{ route('user.requests.rate', $request) }}" method="POST">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label text-muted small">Rating</label>
                            <select name="customer_rating" class="form-select bg-dark text-white border-secondary rounded-3" required>
                                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                <option value="4">⭐⭐⭐⭐ Good</option>
                                <option value="3">⭐⭐⭐ Average</option>
                                <option value="2">⭐⭐ Fair</option>
                                <option value="1">⭐ Poor</option>
                            </select>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label text-muted small">Comment</label>
                            <textarea name="customer_feedback" class="form-control bg-dark text-white border-secondary rounded-3" rows="3" placeholder="How was the service?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100">Submit Review</button>
                    </form>
                </div>
                @elseif($request->customer_rating)
                <div class="custom-card p-4 text-center">
                    <h5 class="mb-3 text-muted">Your Rating</h5>
                    <div class="display-4 text-warning mb-2">
                        @for($i=1;$i<=5;$i++)
                            <i class="bi {{ $i <= $request->customer_rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                    <p class="fst-italic text-muted">"{{ $request->customer_feedback }}"</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab 3: History -->
    <div class="tab-pane fade" id="history" role="tabpanel">
        <div class="custom-card p-4">
            <h5 class="mb-4 border-bottom border-secondary pb-3">Full Lifecycle Logs</h5>
            <div class="timeline">
                @foreach($request->auditLogs()->with('user')->latest()->get() as $log)
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="p-2 rounded-circle bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                        <div class="ms-3 border-start border-secondary border-opacity-25 ps-3">
                            <div class="d-flex align-items-center mb-1">
                                <span class="fw-bold me-2">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                                <small class="text-muted">{{ $log->created_at->format('M d, Y H:i') }}</small>
                            </div>
                            <p class="text-muted small mb-0">
                                @if($log->action === 'status_change')
                                    Moved from <span class="text-info">{{ $log->old_value }}</span> to <span class="text-success">{{ $log->new_value }}</span>
                                @elseif($log->action === 'digital_signature')
                                    Signed and finalized by {{ $log->user->name }}.
                                @endif
                                <br>
                                <span class="opacity-50 text-xs">Origin IP: {{ $log->ip_address }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



@endsection
