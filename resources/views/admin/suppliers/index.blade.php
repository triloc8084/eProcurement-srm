@extends('layouts.main')

@section('title', 'Suppliers Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">Suppliers</h2>
        <p class="text-muted mb-0">Manage your vendor relationships.</p>
    </div>
    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i> Add Supplier
    </a>
</div>

<div class="custom-card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="background: transparent;">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">ID</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Company / Contact</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Email</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Phone</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Status</th>
                    <th class="text-muted fw-normal border-bottom border-secondary text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td class="align-middle">#{{ $loop->iteration }}</td>
                    <td class="align-middle">
                        <div class="fw-bold">{{ $supplier->company_name }}</div>
                        <small class="text-muted">{{ $supplier->name }}</small>
                    </td>
                    <td class="align-middle">{{ $supplier->email }}</td>
                    <td class="align-middle">{{ $supplier->phone ?? 'N/A' }}</td>
                    <td class="align-middle">
                        @if($supplier->status === 'active')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">Active</span>
                        @elseif($supplier->status === 'inactive')
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill">Inactive</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill">Blacklisted</span>
                        @endif
                    </td>
                    <td class="align-middle text-end">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-info rounded-circle me-1" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="d-inline" data-confirm="Are you sure you want to delete this supplier?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-people mb-3 d-block fs-1"></i>
                        No suppliers found. Click "Add Supplier" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $suppliers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
