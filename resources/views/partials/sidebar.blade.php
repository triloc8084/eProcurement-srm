<div class="sidebar d-flex flex-column">
    <div class="px-4 pb-4 border-bottom border-secondary" style="border-color: var(--glass-border) !important;">
        <h3 class="brand-font text-white mb-0 mt-2">
            <i class="bi bi-box-seam text-primary me-2"></i>eProcure
        </h3>
    </div>
    
    <div class="flex-grow-1 overflow-auto mt-4">
        <ul class="nav flex-column mb-auto">
            @if(Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> Supplier Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Suppliers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.procurements.index') }}" class="nav-link {{ request()->routeIs('admin.procurements.*') ? 'active' : '' }}">
                        <i class="bi bi-cart"></i> Manage Orders
                    </a>
                </li>

                {{-- User section removed --}}
                <li class="nav-item">
                    <a href="{{ route('admin.knowledge-base.index') }}" class="nav-link {{ request()->routeIs('admin.knowledge-base.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-richtext"></i> Knowledge Base
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                        <i class="bi bi-bell"></i> Send Alerts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up"></i> Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> Customer Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.suppliers.index') }}" class="nav-link {{ request()->routeIs('user.suppliers.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> View Suppliers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.requests.create') }}" class="nav-link {{ request()->routeIs('user.requests.create') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-plus"></i> Create Request
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.requests.index') }}" class="nav-link {{ request()->routeIs('user.requests.index') ? 'active' : '' }}">
                        <i class="bi bi-list-check"></i> My Service Requests
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.knowledge-base.index') }}" class="nav-link {{ request()->routeIs('user.knowledge-base.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-richtext"></i> Knowledge Base
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.notifications.index') }}" class="nav-link {{ request()->routeIs('user.notifications.*') ? 'active' : '' }}">
                        <i class="bi bi-bell"></i> Send Alerts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> Profile Management
                    </a>
                </li>

            @endif
            
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start text-danger border-0 bg-transparent" style="padding-left: 1.5rem;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
