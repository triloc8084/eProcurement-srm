@extends('layouts.main')

@section('title', 'New Request')

@section('content')
<div class="mb-4">
    <a href="{{ route('user.requests.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Back to My Requests
    </a>
    <h2 class="brand-font mb-1">Create Procurement Request</h2>
    <p class="text-muted mb-0">Submit a new request for goods or services.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="custom-card p-4">
            <form action="{{ route('user.requests.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                
                <div class="mb-4">
                    <label class="form-label text-muted">Request Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control bg-dark text-white border-secondary @error('title') is-invalid @enderror" value="{{ old('title', $reorder->title ?? '') }}" required placeholder="e.g. 15 New Dell Laptops for Engineering Dept">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Detailed Description <span class="text-danger">*</span></label>
                    <textarea name="description" rows="5" class="form-control bg-dark text-white border-secondary @error('description') is-invalid @enderror" required placeholder="Provide specifications, quantities, and justification...">{{ old('description', $reorder->description ?? '') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Preferred Supplier (Optional)</label>
                        <select name="supplier_id" class="form-select bg-dark text-white border-secondary @error('supplier_id') is-invalid @enderror">
                            <option value="">-- No Preference / Let Admin Decide --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $reorder->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Estimated Budget ($)</label>
                        <input type="number" step="0.01" name="budget" class="form-control bg-dark text-white border-secondary @error('budget') is-invalid @enderror" value="{{ old('budget', $reorder->budget ?? '') }}" placeholder="0.00">
                        @error('budget') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>


                <div class="mb-4">
                    <label class="form-label text-muted">Attachments (Quotes, Specs, etc.)</label>
                    <input type="file" name="attachment" class="form-control bg-dark text-white border-secondary @error('attachment') is-invalid @enderror">
                    <div class="form-text text-muted small mt-1">Accepted: PDF, JPG, PNG, DOC (Max 2MB)</div>
                    @error('attachment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end border-top border-secondary pt-4" style="border-color: var(--glass-border) !important;">
                    <a href="{{ route('user.requests.index') }}" class="btn btn-outline-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary-custom px-4">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
