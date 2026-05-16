@extends('layouts.main')

@section('title', 'Edit Supplier')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.suppliers.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Back to Suppliers
    </a>
    <h2 class="brand-font mb-1">Edit Supplier: {{ $supplier->company_name }}</h2>
    <p class="text-muted mb-0">Update vendor details.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="custom-card p-4">
            <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" class="form-control bg-dark text-white border-secondary @error('company_name') is-invalid @enderror" value="{{ old('company_name', $supplier->company_name) }}" required>
                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Contact Person <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror" value="{{ old('name', $supplier->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control bg-dark text-white border-secondary @error('email') is-invalid @enderror" value="{{ old('email', $supplier->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Phone Number</label>
                        <input type="text" name="phone" class="form-control bg-dark text-white border-secondary @error('phone') is-invalid @enderror" value="{{ old('phone', $supplier->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Company Address</label>
                    <textarea name="address" rows="3" class="form-control bg-dark text-white border-secondary @error('address') is-invalid @enderror">{{ old('address', $supplier->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Status</label>
                    <select name="status" class="form-select bg-dark text-white border-secondary @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', $supplier->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $supplier->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="blacklisted" {{ old('status', $supplier->status) == 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end border-top border-secondary pt-4" style="border-color: var(--glass-border) !important;">
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary-custom px-4">Update Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
