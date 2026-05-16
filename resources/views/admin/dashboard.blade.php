@extends('layouts.main')

@section('title', 'Supplier Portal')


@section('content')

<!-- Hero Section -->
@include('partials.dashboard-hero')

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="brand-font mb-1">Supplier Dashboard</h2>
        <p class="text-muted mb-0">Manage your catalog, orders, and customer requests.</p>
    </div>

    <a href="{{ route('admin.reports.index') }}" class="btn btn-primary-custom">
        <i class="bi bi-download me-2"></i> Download Reports
    </a>
</div>

<!-- Stats Row -->
<div class="d-grid gap-4 mb-5 fade-in-up delay-100" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">Total Suppliers</h6>
            <div class="p-2 bg-primary bg-opacity-10 rounded text-primary">
                <i class="bi bi-people fs-5"></i>
            </div>
        </div>
        <h3 class="mb-2 fw-bold">{{ $totalSuppliers }}</h3>
        <p class="text-success mb-0 fs-sm"><i class="bi bi-arrow-up-right me-1"></i> Active vendors</p>
    </div>
    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">Pending Requests</h6>
            <div class="p-2 bg-warning bg-opacity-10 rounded text-warning">
                <i class="bi bi-hourglass-split fs-5"></i>
            </div>
        </div>
        <h3 class="mb-2 fw-bold">{{ $pendingRequests }}</h3>
        <p class="text-warning mb-0 fs-sm">Requires attention</p>
    </div>
    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">Approved POs</h6>
            <div class="p-2 bg-success bg-opacity-10 rounded text-success">
                <i class="bi bi-check-circle fs-5"></i>
            </div>
        </div>
        <h3 class="mb-2 fw-bold">{{ $approvedPOs }}</h3>
        <p class="text-success mb-0 fs-sm"><i class="bi bi-check-all me-1"></i> Ready for fulfillment</p>
    </div>
    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">Total Spend</h6>
            <div class="p-2 bg-info bg-opacity-10 rounded text-info">
                <i class="bi bi-currency-dollar fs-5"></i>
            </div>
        </div>
        <h3 class="mb-2 fw-bold">${{ number_format($totalSpend, 2) }}</h3>
        <p class="text-muted mb-0 fs-sm">Approved budgets</p>
    </div>
</div>

<!-- Charts & Activity Overview (3 Columns) -->
<div class="d-grid gap-4 mb-5 fade-in-up delay-200" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
    <!-- Spend Chart -->
    <div class="custom-card p-4 h-100">
        <h5 class="mb-4 fw-bold">Procurement Spend (YTD)</h5>
        <div style="height: 300px;">
            <canvas id="spendChart"></canvas>
        </div>
    </div>
    
    <!-- Supplier Chart -->
    <div class="custom-card p-4 h-100">
        <h5 class="mb-4 fw-bold">Supplier Status</h5>
        <div style="height: 300px;" class="d-flex justify-content-center">
            <canvas id="supplierChart"></canvas>
        </div>
    </div>

    <!-- Department Spend Chart -->
    <div class="custom-card p-4 h-100">
        <h5 class="mb-4 fw-bold">Spend by Department</h5>
        <div style="height: 300px;">
            <canvas id="deptChart"></canvas>
        </div>
    </div>
</div>

<div class="d-grid gap-4 mb-5 fade-in-up delay-300" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
    <!-- Activity Feed -->
    <div class="custom-card p-4 h-100 d-flex flex-column">

        <h5 class="mb-4 fw-bold">Recent Activity</h5>
        <div class="activity-feed flex-grow-1">
            @forelse($activities as $activity)
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
                        $iconClass = $iconMap[$activity->type ?? 'info'] ?? 'bi-bell';
                        $bgClass = $bgMap[$activity->type ?? 'info'] ?? 'bg-primary text-primary';
                    @endphp
                    <div class="{{ $bgClass }} bg-opacity-10 rounded-circle p-2">
                        <i class="bi {{ $iconClass }}"></i>
                    </div>
                </div>
                <div class="ms-3">
                    <p class="mb-0 text-sm fw-medium">{{ $activity->title }}</p>
                    <small class="text-muted">{{ $activity->message }} • {{ $activity->created_at->diffForHumans() }}</small>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">No recent activity.</div>
            @endforelse
        </div>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-light btn-sm w-100 mt-4">View All Activity</a>
    </div>
</div>

<!-- Full Width: Recent Procurement Requests -->
<div class="custom-card p-4 mb-5 fade-in-up delay-300">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 fw-bold">Recent Procurement Requests</h5>
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
                    <th class="text-muted fw-normal border-bottom border-secondary">Customer Name</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Date</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse($recentRequests as $req)
                <tr class="request-row" data-status="{{ $req->status }}">
                    <td class="align-middle">#{{ $loop->iteration }}</td>
                    <td class="align-middle fw-bold">{{ $req->title }}</td>
                    <td class="align-middle">{{ $req->user->name ?? 'Unknown' }}</td>
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
                    <td colspan="5" class="text-center py-4 text-muted">No recent requests available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Full Width: Quick Actions -->
<div class="custom-card p-4 mb-5 fade-in-up delay-400">
    <h5 class="mb-4 fw-bold">Quick Actions</h5>
    <div class="d-grid gap-3" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-outline-light text-start p-3 d-flex flex-column align-items-center text-center rounded">
            <i class="bi bi-person-plus fs-2 mb-2 text-primary"></i>
            <span class="fw-bold">Add Supplier</span>
            <small class="text-muted">Register a new vendor</small>
        </a>
        <a href="{{ route('admin.procurements.create') }}" class="btn btn-outline-light text-start p-3 d-flex flex-column align-items-center text-center rounded">
            <i class="bi bi-file-earmark-plus fs-2 mb-2 text-secondary"></i>
            <span class="fw-bold">Create PO</span>
            <small class="text-muted">Generate purchase order</small>
        </a>
        <a href="{{ route('admin.knowledge-base.create') }}" class="btn btn-outline-light text-start p-3 d-flex flex-column align-items-center text-center rounded">
            <i class="bi bi-journal-text fs-2 mb-2 text-success"></i>
            <span class="fw-bold">Knowledge Base</span>
            <small class="text-muted">Add new policy document</small>
        </a>
        <a href="{{ route('admin.notifications.create') }}" class="btn btn-outline-light text-start p-3 d-flex flex-column align-items-center text-center rounded">
            <i class="bi bi-broadcast fs-2 mb-2 text-warning"></i>
            <span class="fw-bold">Send Alert</span>
            <small class="text-muted">Broadcast to customers</small>
        </a>

    </div>
</div>

<!-- Full Width: Suppliers Analytics -->
<div class="custom-card p-4 mb-5 fade-in-up delay-500">
    <h5 class="mb-4 fw-bold">Suppliers Analytics Overview</h5>
    <div class="d-grid gap-4" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); text-align: center;">
        <div class="p-4 bg-secondary bg-opacity-10 rounded">
            <h2 class="mb-2 text-primary fw-bold">85%</h2>
            <h6 class="text-muted mb-0">On-Time Delivery Rate</h6>
        </div>
        <div class="p-4 bg-secondary bg-opacity-10 rounded">
            <h2 class="mb-2 text-success fw-bold">{{ number_format($averageRating, 1) }} <small class="fs-6">/ 5</small></h2>
            <h6 class="text-muted mb-0">Average Satisfaction Score</h6>
        </div>

        <div class="p-4 bg-secondary bg-opacity-10 rounded">
            <h2 class="mb-2 text-warning fw-bold">12</h2>
            <h6 class="text-muted mb-0">Risk Assessments Needed</h6>
        </div>
        <div class="p-4 bg-secondary bg-opacity-10 rounded">
            <h2 class="mb-2 text-info fw-bold">$2.4M</h2>
            <h6 class="text-muted mb-0">Total Supplier Savings</h6>
        </div>
    </div>
</div>

<!-- Include Scripts for Charts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Procurement Spend Chart (Line)
    const spendCtx = document.getElementById('spendChart').getContext('2d');
    new Chart(spendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthsLabels) !!},
            datasets: [{
                label: 'Spend ($)',
                data: {!! json_encode($monthlySpendData) !!},
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#94a3b8' } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });

    // Supplier Status Chart (Doughnut)
    const supplierCtx = document.getElementById('supplierChart').getContext('2d');
    new Chart(supplierCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Pending', 'Inactive'],
            datasets: [{
                data: [{{ $activeSuppliers }}, {{ $pendingSuppliers }}, {{ $inactiveSuppliers }}],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8', padding: 20 } }
            },
            cutout: '75%'
        }
    });

    // Department Spend Chart (Bar)
    const deptCtx = document.getElementById('deptChart').getContext('2d');
    new Chart(deptCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($deptLabels) !!},
            datasets: [{
                label: 'Total Spend ($)',
                data: {!! json_encode($deptValues) !!},
                backgroundColor: '#0ea5e9',
                borderRadius: 8,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y', // Horizontal bars
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#94a3b8' } },
                y: { grid: { display: false }, ticks: { color: '#94a3b8' } }
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
