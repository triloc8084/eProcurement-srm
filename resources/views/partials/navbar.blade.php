<nav class="navbar navbar-expand-lg top-navbar w-100 py-3">
    <div class="container-fluid px-3">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center text-white" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
            <i class="bi bi-box-seam text-primary me-2 fs-3"></i>
            <h4 class="brand-font mb-0 mt-1">Supplier Portal</h4>
        </a>


        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-2"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.dashboard') }}">Supplier Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.suppliers.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.suppliers.index') }}">Suppliers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.procurements.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.procurements.index') }}">Manage Orders</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="adminMoreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            More Options
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark shadow border-secondary" aria-labelledby="adminMoreDropdown">
                            {{-- Users section removed --}}
                            <li><a class="dropdown-item {{ request()->routeIs('admin.knowledge-base.*') ? 'active' : '' }}" href="{{ route('admin.knowledge-base.index') }}">Knowledge Base</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}">Send Alerts</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">Reports</a></li>
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li><a class="dropdown-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">Settings</a></li>
                        </ul>

                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('user.dashboard') ? 'fw-bold text-primary' : '' }}" href="{{ route('user.dashboard') }}">Customer Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('user.suppliers.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('user.suppliers.index') }}">Suppliers</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userRequestsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Requests
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark shadow border-secondary" aria-labelledby="userRequestsDropdown">
                            <li><a class="dropdown-item {{ request()->routeIs('user.requests.create') ? 'active' : '' }}" href="{{ route('user.requests.create') }}">Create Request</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('user.requests.index') ? 'active' : '' }}" href="{{ route('user.requests.index') }}">View Status</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('user.knowledge-base.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('user.knowledge-base.index') }}">Knowledge Base</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('user.notifications.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('user.notifications.index') }}">Send Alerts</a>
                    </li>

                @endif
            </ul>

            <!-- Right side (Notifications & Profile) -->
            <div class="d-flex align-items-center gap-4 ms-auto mt-3 mt-lg-0 pt-3 pt-lg-0">

                <div class="dropdown">
                    <button class="btn btn-link text-white p-0 position-relative dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="outline: none; border: none; box-shadow: none;">
                        <i class="bi bi-bell fs-5"></i>
                        @php
                            $unreadCount = Auth::user()->customNotifications()->where('is_read', false)->count();
                        @endphp
                        <span id="notif-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ $unreadCount > 0 ? '' : 'd-none' }}" style="font-size: 0.65rem;">
                            {{ $unreadCount }}
                        </span>
                    </button>
                    <ul id="notif-list" class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow" style="width: 320px; max-height: 400px; overflow-y: auto;">

                        <li><h6 class="dropdown-header border-bottom border-secondary pb-2 mb-2">Notifications</h6></li>
                        @php
                            $notifications = Auth::user()->customNotifications()->where('is_read', false)->latest()->get();
                        @endphp
                        @forelse($notifications as $notif)
                        <li>
                            <a class="dropdown-item py-2 d-flex flex-column" href="{{ route('notifications.read', $notif->id) }}">
                                <span class="fw-bold">{{ $notif->title }}</span>
                                <small class="text-muted text-wrap" style="white-space: normal;">{{ $notif->message }}</small>
                                <small class="text-secondary mt-1">{{ $notif->created_at->diffForHumans() }}</small>
                            </a>
                        </li>
                        @empty
                        <li><div class="dropdown-item text-muted text-center py-3">No new notifications</div></li>
                        @endforelse
                    </ul>
                </div>
                


                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="position-relative d-inline-block me-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff" alt="" width="36" height="36" class="rounded-circle border-2 border-primary shadow-sm" style="box-shadow: 0 0 10px rgba(79, 70, 229, 0.5) !important;">
                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
                        </div>
                        <div class="d-none d-sm-flex flex-column lh-1">
                            <strong>{{ Auth::user()->name }}</strong>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->role === 'admin' ? 'Supplier' : 'Customer' }}</small>

                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider border-secondary"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i> Sign out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const body = document.documentElement;

    // Check saved theme
    const savedTheme = localStorage.getItem('theme') || 'dark';
    body.setAttribute('data-theme', savedTheme);
    updateIcon(savedTheme);

    themeToggle?.addEventListener('click', () => {
        const currentTheme = body.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        body.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon(newTheme);
    });

    function updateIcon(theme) {
        if (!themeIcon) return;
        if(theme === 'light') {
            themeIcon.classList.replace('bi-moon-stars', 'bi-sun');
            themeIcon.classList.add('text-warning');
        } else {
            themeIcon.classList.replace('bi-sun', 'bi-moon-stars');
            themeIcon.classList.remove('text-warning');
        }
    }
});
</script>
