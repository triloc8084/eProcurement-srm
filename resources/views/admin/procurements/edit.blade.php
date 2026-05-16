@extends('layouts.main')

@section('title', 'Review Request')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.procurements.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Back to Requests
    </a>
    <h2 class="brand-font mb-1">Review Request #{{ $procurement->id }}</h2>
    <p class="text-muted mb-0">Requested by {{ $procurement->user->name ?? 'Unknown' }} on {{ $procurement->created_at->format('M d, Y') }}</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="custom-card p-4 h-100">
            <h5 class="mb-4 border-bottom border-secondary pb-3" style="border-color: var(--glass-border) !important;">Request Details</h5>
            
            <div class="mb-4">
                <h6 class="text-muted mb-1">Title</h6>
                <p class="fs-5">{{ $procurement->title }}</p>
            </div>
            
            <div class="mb-4">
                <h6 class="text-muted mb-1">Description / Specifications</h6>
                <div class="p-3 bg-dark rounded border border-secondary" style="border-color: var(--glass-border) !important;">
                    {!! nl2br(e($procurement->description)) !!}
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Initial Budget Estimate</h6>
                    <p class="fs-5">{{ $procurement->budget ? '$'.number_format($procurement->budget, 2) : 'Not Specified' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Current Status (For You)</h6>
                    @if($currentStatus === 'pending')
                        <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-pill">Pending Review</span>
                    @elseif($currentStatus === 'approved')
                        <span class="badge bg-success px-3 py-2 fs-6 rounded-pill">Approved</span>
                    @elseif($currentStatus === 'completed')
                        <span class="badge bg-primary px-3 py-2 fs-6 rounded-pill">Completed</span>
                    @else
                        <span class="badge bg-danger px-3 py-2 fs-6 rounded-pill">Rejected</span>
                    @endif
                </div>

            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="custom-card p-4">
            <h5 class="mb-4 border-bottom border-secondary pb-3" style="border-color: var(--glass-border) !important;">Admin Action</h5>
            
            <form action="{{ route('admin.procurements.update', $procurement) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="form-label text-muted">Assign Supplier <span class="text-danger">*</span></label>
                    <select name="supplier_id" class="form-select bg-dark text-white border-secondary">
                        <option value="">-- Select a Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ (old('supplier_id', $procurement->supplier_id) == $supplier->id) ? 'selected' : '' }}>
                                {{ $supplier->company_name }} ({{ $supplier->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Final Budget ($)</label>
                    <input type="number" step="0.01" name="budget" class="form-control bg-dark text-white border-secondary" value="{{ old('budget', $procurement->budget) }}">
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Update Your Decision <span class="text-danger">*</span></label>
                    <select name="status" class="form-select bg-dark text-white border-secondary">
                        <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $currentStatus == 'approved' ? 'selected' : '' }}>Approve Request</option>
                        <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>Reject Request</option>
                        <option value="completed" {{ $currentStatus == 'completed' ? 'selected' : '' }}>Mark Completed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Internal Supplier Notes (Private)</label>
                    <textarea name="internal_notes" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Notes for other suppliers/admins...">{{ old('internal_notes', $procurement->internal_notes) }}</textarea>
                    <small class="text-muted">These notes are only visible to other Suppliers.</small>
                </div>



                <button type="submit" class="btn btn-primary-custom w-100 py-2">Save Updates</button>
            </form>
            
            <form action="{{ route('admin.procurements.destroy', $procurement) }}" method="POST" class="mt-3" data-confirm="WARNING: This will permanently delete this procurement request. Are you sure?">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100 py-2">Delete Request</button>
            </form>
        </div>

        <div class="mt-4">
            @include('partials.chat', ['procurement' => $procurement])
        </div>

        <div class="mt-4 custom-card p-4">
            <h5 class="mb-4 border-bottom border-secondary pb-3" style="border-color: var(--glass-border) !important;">
                <i class="bi bi-shield-check text-success me-2"></i> Activity Log (Audit Trail)
            </h5>
            <div class="small overflow-auto" style="max-height: 300px;">
                @forelse($procurement->auditLogs()->with('user')->latest()->get() as $log)
                    <div class="mb-3 pb-3 border-bottom border-secondary border-opacity-10">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-primary">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                            <span class="text-muted text-xs">{{ $log->created_at->format('M d, H:i') }}</span>
                        </div>
                        <div class="text-muted mt-1">
                            @if($log->action === 'status_change')
                                Changed status from <span class="badge bg-secondary">{{ $log->old_value }}</span> to <span class="badge bg-primary">{{ $log->new_value }}</span>
                            @elseif($log->action === 'digital_signature')
                                Digitally signed and finalized.
                            @endif
                        </div>
                        <div class="mt-1 opacity-50" style="font-size: 0.7rem;">
                            By {{ $log->user->name ?? 'System' }} • IP: {{ $log->ip_address }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">No activity recorded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>


@endsection
