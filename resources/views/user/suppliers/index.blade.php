@extends('layouts.main')

@section('title', 'Registered Suppliers')

@section('content')
<div class="mb-5 text-center">
    <h1 class="brand-font display-5 mb-3">Approved Suppliers</h1>
    <p class="text-muted lead mx-auto" style="max-width: 600px;">Browse our network of trusted vendors and partners.</p>
</div>
<div class="row justify-content-center mb-5">
    <div class="col-md-6">
        <form action="{{ route('user.suppliers.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control bg-dark text-white border-secondary rounded-pill px-4" placeholder="Search by name, company, or location..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary-custom rounded-pill px-4">Search</button>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($suppliers as $supplier)
    <div class="col-md-4">
        <div class="custom-card p-4 h-100 d-flex flex-column">
            <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-3" style="border-color: var(--glass-border) !important;">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-building fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">{{ $supplier->company_name }}</h5>
                    <div class="d-flex align-items-center">
                        @if($supplier->rating_count > 0)
                            <div class="text-warning small me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= round($supplier->average_rating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                            <small class="text-muted">({{ $supplier->rating_count }})</small>
                        @else
                            <small class="text-muted">No reviews yet</small>
                        @endif
                    </div>
                    @if($supplier->category)
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill mt-2" style="font-size: 0.65rem; border: 1px solid rgba(79, 70, 229, 0.2);">{{ $supplier->category }}</span>
                    @endif
                </div>


            </div>
            
            <div class="flex-grow-1">
                <div class="mb-2">
                    <i class="bi bi-envelope text-muted me-2"></i> {{ $supplier->email }}
                </div>
                @if($supplier->phone)
                <div class="mb-2">
                    <i class="bi bi-telephone text-muted me-2"></i> {{ $supplier->phone }}
                </div>
                @endif
                @if($supplier->address)
                <div class="mb-2">
                    <i class="bi bi-geo-alt text-muted me-2"></i> {{ Str::limit($supplier->address, 50) }}
                </div>
                @endif
            </div>
            
            <div class="mt-4 pt-3 border-top border-secondary" style="border-color: var(--glass-border) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-success small fw-medium"><i class="bi bi-patch-check-fill me-1"></i> Verified</span>
                    <a href="{{ route('user.suppliers.show', $supplier) }}" class="text-primary text-decoration-none fw-medium">View Profile <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>

        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="bi bi-people display-1 text-muted mb-3 d-block"></i>
        <h4 class="text-muted">No active suppliers found</h4>
    </div>
    @endforelse
</div>

<div class="mt-5">
    {{ $suppliers->links('pagination::bootstrap-5') }}
</div>
@endsection
