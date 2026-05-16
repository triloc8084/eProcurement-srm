@extends('layouts.main')

@section('title', 'My Requests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">My Requests</h2>
        <p class="text-muted mb-0">Track your procurement and purchase requests.</p>
    </div>
    <a href="{{ route('user.requests.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i> New Request
    </a>
</div>

<div class="custom-card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="background: transparent;">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">ID</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Title</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Preferred Supplier</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Budget</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Date</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Status</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Actions</th>
                </tr>

            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td class="align-middle">#{{ $loop->iteration }}</td>
                    <td class="align-middle fw-bold">
                        <a href="{{ route('user.requests.show', $req) }}" class="text-white text-decoration-none hover-primary">
                            {{ $req->title }}
                        </a>
                    </td>

                    <td class="align-middle">{{ $req->supplier ? $req->supplier->company_name : 'No Preference' }}</td>
                    <td class="align-middle">{{ $req->budget ? '$'.number_format($req->budget, 2) : 'TBD' }}</td>
                    <td class="align-middle">{{ $req->created_at->format('M d, Y') }}</td>
                    <td class="align-middle">
                        @if($req->status === 'pending')
                            <span class="badge bg-warning text-dark px-2 py-1 rounded-pill">Pending</span>
                        @elseif($req->status === 'approved')
                            <span class="badge bg-success px-2 py-1 rounded-pill">Approved</span>
                        @elseif($req->status === 'completed')
                            <span class="badge bg-primary px-2 py-1 rounded-pill">Completed</span>
                        @else
                            <span class="badge bg-danger px-2 py-1 rounded-pill">Rejected</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('user.requests.create', ['reorder_id' => $req->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-repeat me-1"></i> Reorder
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-file-earmark-x mb-3 d-block fs-1"></i>
                        You haven't submitted any requests yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $requests->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
