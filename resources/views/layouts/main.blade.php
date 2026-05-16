<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | eProcurement SRM</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

    <!-- Main Content Wrapper -->
    <div class="main-content">
        <!-- Top Navbar -->
        @include('partials.navbar')

            <!-- Page Content -->
            <div class="container-fluid mt-4">
                @if(session('success'))
                    <div class="alert alert-success bg-success text-white border-0 alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger bg-danger text-white border-0 alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // SweetAlert for Delete Confirmations
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.hasAttribute('data-confirm')) {
                e.preventDefault();
                const form = e.target;
                const message = form.getAttribute('data-confirm');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, proceed!',
                    background: '#1f2937',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.removeAttribute('data-confirm'); // Remove to prevent loop
                        form.submit();
                    }
                });
            }
        });
        // Real-time Notification Polling
        let lastNotificationId = null;
        function checkNotifications() {
            fetch('{{ route('notifications.poll') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.unread_count > 0) {
                        const badge = document.getElementById('notif-badge');
                        if (badge) {
                            badge.innerText = data.unread_count;
                            badge.classList.remove('d-none');
                        }
                    } else {
                        const badge = document.getElementById('notif-badge');
                        if (badge) badge.classList.add('d-none');
                    }

                    if (data.latest && data.latest.id !== lastNotificationId) {
                        // Avoid showing the same notification multiple times
                        if (lastNotificationId !== null) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'info',
                                title: data.latest.title,
                                text: data.latest.message,
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                background: '#1f2937',
                                color: '#fff'
                            });
                        }
                        lastNotificationId = data.latest.id;
                    }

                })
                .catch(err => console.error('Notification error:', err));
        }

        // Poll every 10 seconds
        setInterval(checkNotifications, 10000);
        checkNotifications(); // Initial check

        // Global Button Loading State
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                if (btn && !this.hasAttribute('data-confirm')) {
                    const originalText = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> Processing...`;
                }
            });
        });
    </script>


</body>
</html>
