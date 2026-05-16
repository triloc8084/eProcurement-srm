@extends('layouts.main')

@section('title', 'Procurement Requests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">Procurement Requests</h2>
        <p class="text-muted mb-0">Review, approve, and manage all purchase orders.</p>
    </div>
</div>

<div class="custom-card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="background: transparent;">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">ID</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Title & Description</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Requested By</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Supplier</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Budget</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Status</th>
                    <th class="text-muted fw-normal border-bottom border-secondary text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($procurements as $req)
                <tr>
                    <td class="align-middle">#{{ $loop->iteration }}</td>
                    <td class="align-middle">
                        <div class="fw-bold text-truncate" style="max-width: 250px;">{{ $req->title }}</div>
                        <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">{{ Str::limit($req->description, 50) }}</small>
                    </td>
                    <td class="align-middle">{{ $req->user->name ?? 'Unknown' }}</td>
                    <td class="align-middle">{{ $req->supplier->company_name ?? 'Not Assigned' }}</td>
                    <td class="align-middle">{{ $req->budget ? '$'.number_format($req->budget, 2) : 'TBD' }}</td>
                    <td class="align-middle">
                        @php $currentAdminStatus = $req->getStatusForAdmin(Auth::id()); @endphp
                        @if($currentAdminStatus === 'pending')
                            <span class="badge bg-warning text-dark px-2 py-1 rounded-pill">Pending</span>
                        @elseif($currentAdminStatus === 'approved')
                            <span class="badge bg-success px-2 py-1 rounded-pill">Approved</span>
                        @elseif($currentAdminStatus === 'completed')
                            <span class="badge bg-primary px-2 py-1 rounded-pill">Completed</span>
                        @else
                            <span class="badge bg-danger px-2 py-1 rounded-pill">Rejected</span>
                        @endif
                    </td>

                    <td class="align-middle text-end">
                        <a href="{{ route('admin.procurements.edit', $req) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Review <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox mb-3 d-block fs-1"></i>
                        No procurement requests available.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $procurements->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
