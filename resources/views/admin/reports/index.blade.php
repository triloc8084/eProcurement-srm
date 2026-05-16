@extends('layouts.main')

@section('title', 'Reports')

@section('content')
<div class="mb-4">
    <h2 class="brand-font mb-1">System Reports</h2>
    <p class="text-muted mb-0">Download Financial and Operational analytics.</p>
</div>

<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="custom-card p-5 h-100 text-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-people display-6"></i>
            </div>
            <h4 class="fw-bold mb-3">Suppliers Directory</h4>
            <p class="text-muted mb-4">Export a complete list of all registered suppliers, including their contact information, addresses, and current platform status.</p>
            <a href="{{ route('admin.reports.suppliers.export') }}" class="btn btn-outline-light rounded-pill px-4">
                <i class="bi bi-download me-2"></i> Download CSV
            </a>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="custom-card p-5 h-100 text-center">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-file-earmark-bar-graph display-6"></i>
            </div>
            <h4 class="fw-bold mb-3">Procurement History</h4>
            <p class="text-muted mb-4">Export a comprehensive log of all purchase orders, including requested budgets, assigned suppliers, and real-time approval statuses.</p>
            <a href="{{ route('admin.reports.procurements.export') }}" class="btn btn-primary-custom rounded-pill px-4">
                <i class="bi bi-download me-2"></i> Download CSV
            </a>
        </div>
    </div>
</div>
@endsection
