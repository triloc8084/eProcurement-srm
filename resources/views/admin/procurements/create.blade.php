@extends('layouts.main')

@section('title', 'Create Purchase Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">Create Purchase Order</h2>
        <p class="text-muted mb-0">Generate and approve a new purchase order directly.</p>
    </div>
    <a href="{{ route('admin.procurements.index') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-2"></i> Back to Procurements
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="custom-card p-4">
            <form action="{{ route('admin.procurements.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-muted">Request Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control bg-dark text-white border-secondary @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control bg-dark text-white border-secondary @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Budget ($)</label>
                        <input type="number" name="budget" step="0.01" class="form-control bg-dark text-white border-secondary @error('budget') is-invalid @enderror" value="{{ old('budget') }}">
                        @error('budget') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Assign Supplier</label>
                        <select name="supplier_id" class="form-select bg-dark text-white border-secondary @error('supplier_id') is-invalid @enderror">
                            <option value="">-- Select a Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Initial Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select bg-dark text-white border-secondary @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', 'approved') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <hr class="border-secondary my-4">
                
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary-custom px-4">Create Purchase Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
