@extends('layouts.main')

@section('title', 'Customer Dashboard')
@section('content')

<!-- Hero Section -->
@include('partials.dashboard-hero')

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="brand-font mb-1">Customer Dashboard</h2>
        <p class="text-muted mb-0">Track your orders and service requests.</p>
    </div>

    <a href="{{ route('user.requests.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i> New Request
    </a>
</div>

<!-- Stats Row -->
<div class="d-grid gap-4 mb-5 fade-in-up delay-100" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">My Active Requests</h6>
            <div class="p-2 bg-primary bg-opacity-10 rounded text-primary">
                <i class="bi bi-file-earmark-text fs-5"></i>
            </div>
        </div>
        <h3 class="mb-0 fw-bold">{{ $activeRequests }}</h3>
    </div>
    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">Approved Requests</h6>
            <div class="p-2 bg-success bg-opacity-10 rounded text-success">
                <i class="bi bi-check-circle fs-5"></i>
            </div>
        </div>
        <h3 class="mb-0 fw-bold">{{ $approvedRequests }}</h3>
    </div>
    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">Unread Notifications</h6>
            <div class="p-2 bg-danger bg-opacity-10 rounded text-danger">
                <i class="bi bi-bell fs-5"></i>
            </div>
        </div>
        <h3 class="mb-0 fw-bold">{{ $unreadNotifications }}</h3>
    </div>
</div>

<!-- Charts Section -->
<div class="d-grid gap-4 mb-5 fade-in-up delay-100" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
    <div class="custom-card p-4 h-100">
        <h5 class="mb-4 fw-bold">My Request Status</h5>
        <div style="height: 250px;" class="d-flex justify-content-center">
            <canvas id="userStatusChart"></canvas>
        </div>
    </div>
    <div class="custom-card p-4 h-100">
        <h5 class="mb-4 fw-bold">Department Budget Usage</h5>
        <div style="height: 250px;">
            <canvas id="userBudgetChart"></canvas>
        </div>
    </div>
    <div class="custom-card p-4 h-100 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0 fw-bold">Notifications</h5>
            <span class="badge bg-danger rounded-pill">{{ $unreadNotifications }} New</span>
        </div>
        <div class="activity-feed flex-grow-1">
            @forelse($notifications as $notif)
            <div class="d-flex mb-3 pb-3 border-bottom border-secondary border-opacity-50">
                <div class="flex-shrink-0">
                    @php
                        $iconMap = [
                            'success' => 'bi-check-circle',
                            'info' => 'bi-info-circle',
                            'warning' => 'bi-exclamation-triangle',
                            'error' => 'bi-x-circle'
                        ];
                        $bgMap = [
                            'success' => 'bg-success text-success',
                            'info' => 'bg-info text-info',
                            'warning' => 'bg-warning text-warning',
                            'error' => 'bg-danger text-danger'
                        ];
                        $iconClass = $iconMap[$notif->type ?? 'info'] ?? 'bi-bell';
                        $bgClass = $bgMap[$notif->type ?? 'info'] ?? 'bg-primary text-primary';
                    @endphp
                    <div class="{{ $bgClass }} bg-opacity-10 rounded-circle p-2">
                        <i class="bi {{ $iconClass }}"></i>
                    </div>
                </div>
                <div class="ms-3">
                    <p class="mb-0 text-sm fw-medium">{{ $notif->title }}</p>
                    <small class="text-muted">{{ $notif->message }} • {{ $notif->created_at->diffForHumans() }}</small>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">No new notifications.</div>
            @endforelse
        </div>
        <a href="{{ route('notifications.index') }}" class="btn btn-outline-light btn-sm w-100 mt-2">View All</a>
    </div>
</div>

<!-- Full Width: Recent Requests -->
<div class="custom-card p-4 mb-5 fade-in-up delay-200">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold">My Recent Requests</h5>
        
        <!-- Category Filters -->
        <div class="d-flex gap-2">
            <button class="btn btn-primary-custom btn-sm filter-btn active" data-filter="all">All</button>
            <button class="btn btn-outline-light btn-sm filter-btn" data-filter="pending">Pending</button>
            <button class="btn btn-outline-light btn-sm filter-btn" data-filter="approved">Approved</button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">Request ID</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Title</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Supplier</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Budget</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Date Submitted</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentRequests as $req)
                <tr class="request-row" data-status="{{ $req->status }}">
                    <td class="align-middle">#{{ $loop->iteration }}</td>
                    <td class="align-middle fw-bold">{{ $req->title }}</td>
                    <td class="align-middle">{{ $req->supplier->company_name ?? 'Not Assigned' }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">You haven't submitted any requests yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Full Width: Quick Actions (Compact) -->
<div class="custom-card p-4 mb-5 fade-in-up delay-300">
    <h5 class="mb-4 fw-bold">Quick Actions</h5>
    <div class="d-grid gap-3" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        <a href="{{ route('user.requests.create') }}" class="btn btn-outline-light text-start p-3 d-flex flex-column align-items-center text-center rounded">
            <i class="bi bi-plus-lg fs-2 mb-2 text-primary"></i>
            <span class="fw-bold">New Request</span>
            <small class="text-muted">Create procurement request</small>
        </a>
        <a href="{{ route('user.knowledge-base.index') }}" class="btn btn-outline-light text-start p-3 d-flex flex-column align-items-center text-center rounded">
            <i class="bi bi-book fs-2 mb-2 text-success"></i>
            <span class="fw-bold">Browse KB</span>
            <small class="text-muted">View policies and guides</small>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Request Status Chart
    const statusCtx = document.getElementById('userStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Pending', 'Rejected'],
            datasets: [{
                data: [{{ $approvedRequests }}, {{ $activeRequests }}, {{ $rejectedRequests }}],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { color: '#94a3b8' } }
            },
            cutout: '70%'
        }
    });

    // User Budget Chart
    const budgetCtx = document.getElementById('userBudgetChart').getContext('2d');
    new Chart(budgetCtx, {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Budget Used ($)',
                data: {!! json_encode($budgetData) !!},
                backgroundColor: 'rgba(14, 165, 233, 0.5)',
                borderColor: '#0ea5e9',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#94a3b8' } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const rows = document.querySelectorAll('.request-row');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => {
                    b.classList.remove('btn-primary-custom', 'active');
                    b.classList.add('btn-outline-light');
                });
                
                btn.classList.remove('btn-outline-light');
                btn.classList.add('btn-primary-custom', 'active');

                const filterValue = btn.getAttribute('data-filter');

                rows.forEach(row => {
                    if (filterValue === 'all' || row.getAttribute('data-status') === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<!-- Append Portal Content -->
@include('partials.dashboard-portal')

@endsection
