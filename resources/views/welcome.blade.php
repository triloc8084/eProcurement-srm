<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eProcurement SRM | Next-Gen Supplier Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .navbar-landing {
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 10;
            padding: 1.5rem 0;
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            background: rgba(79, 70, 229, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="text-white">

    <!-- Background Gradients -->
    <div class="hero-bg-gradient"></div>
    <div class="hero-bg-gradient-2"></div>

    <!-- Navigation -->
    <nav class="navbar-landing">
        <div class="container d-flex justify-content-between align-items-center">
            <h3 class="brand-font mb-0 text-white"><i class="bi bi-box-seam text-primary me-2"></i>eProcure</h3>
            <div class="d-none d-md-flex gap-4">
                <a href="#hero" class="text-white text-decoration-none fw-medium">Home</a>
                <a href="#about" class="text-white text-decoration-none fw-medium">About</a>
                <a href="#features" class="text-white text-decoration-none fw-medium">Features</a>
                <a href="#how-it-works" class="text-white text-decoration-none fw-medium">How it Works</a>
            </div>
            <div class="d-flex align-items-center">

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light px-4 rounded-pill">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn text-white me-3 fw-medium">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary-custom rounded-pill">Get Started</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-section fade-in-up">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <span class="badge bg-primary text-white mb-3 px-3 py-2 rounded-pill" style="background: rgba(79,70,229,0.2) !important; color: #818cf8 !important; border: 1px solid rgba(79,70,229,0.3);">🚀 Version 2.0 is Live</span>
                    <h1 class="display-3 fw-bold mb-4 brand-font">Smart Supplier <br>Relationship <span class="text-gradient">Management</span></h1>
                    <p class="lead text-muted mb-5 pe-lg-5">Streamline your procurement process, manage suppliers efficiently, and make data-driven decisions with our next-generation eProcurement platform.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5">Start Free Trial</a>
                        <a href="#features" class="btn btn-outline-light btn-lg rounded-pill px-4">Explore Features</a>
                    </div>
                    
                    <div class="mt-5 pt-4 border-top" style="border-color: var(--glass-border) !important;">
                        <div class="d-flex align-items-center gap-4">
                            <div>
                                <h3 class="mb-0 fw-bold">99%</h3>
                                <small class="text-muted">Uptime SLA</small>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">10k+</h3>
                                <small class="text-muted">Suppliers</small>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">24/7</h3>
                                <small class="text-muted">Support</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="glass-panel p-3 shadow-lg transform-hover" style="transform: perspective(1000px) rotateY(-10deg) rotateX(5deg);">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80" alt="Dashboard Preview" class="img-fluid rounded-3">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Statistics Section -->
    <section class="py-5 fade-in-up delay-100" style="position: relative; z-index: 2; margin-top: -80px;">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-3 col-6">
                    <div class="glass-panel p-4 text-center h-100">
                        <div class="fs-1 text-primary mb-2"><i class="bi bi-briefcase"></i></div>
                        <h3 class="fw-bold mb-0 text-white">$2.4B</h3>
                        <p class="text-muted small mb-0">Spend Managed</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="glass-panel p-4 text-center h-100">
                        <div class="fs-1 text-success mb-2"><i class="bi bi-people"></i></div>
                        <h3 class="fw-bold mb-0 text-white">15,000+</h3>
                        <p class="text-muted small mb-0">Active Suppliers</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="glass-panel p-4 text-center h-100">
                        <div class="fs-1 text-info mb-2"><i class="bi bi-clock-history"></i></div>
                        <h3 class="fw-bold mb-0 text-white">3x</h3>
                        <p class="text-muted small mb-0">Faster Approvals</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="glass-panel p-4 text-center h-100">
                        <div class="fs-1 text-warning mb-2"><i class="bi bi-shield-check"></i></div>
                        <h3 class="fw-bold mb-0 text-white">100%</h3>
                        <p class="text-muted small mb-0">Compliance Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 fade-in-up delay-200" style="background: rgba(15, 23, 42, 0.4); position: relative; z-index: 1;">
        <div class="container py-5 border-top border-bottom border-secondary" style="border-color: var(--glass-border) !important;">
            <div class="row align-items-center">
                <div class="col-lg-6 order-2 order-lg-1 mt-5 mt-lg-0">
                    <div class="glass-panel p-2 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=800&q=80" alt="About Us" class="img-fluid rounded-3">
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 ps-lg-5">
                    <h2 class="display-5 fw-bold brand-font mb-4">Empowering Procurement Teams</h2>
                    <p class="lead text-muted mb-4">eProcure is designed to bridge the gap between businesses and their suppliers. We bring transparency, speed, and efficiency to your entire supply chain process.</p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-3 text-muted">
                            <i class="bi bi-check-circle-fill text-primary me-3 fs-5"></i>
                            End-to-end visibility of your procurement lifecycle.
                        </li>
                        <li class="d-flex align-items-center mb-3 text-muted">
                            <i class="bi bi-check-circle-fill text-primary me-3 fs-5"></i>
                            Automated vendor evaluations and onboarding.
                        </li>
                        <li class="d-flex align-items-center mb-3 text-muted">
                            <i class="bi bi-check-circle-fill text-primary me-3 fs-5"></i>
                            Centralized repository for documents and contracts.
                        </li>
                    </ul>
                    <a href="#how-it-works" class="btn btn-outline-light rounded-pill px-4">See How It Works</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 mt-5 fade-in-up delay-300" style="background: transparent; position: relative; z-index: 1;">
        <div class="container py-5">
            <div class="text-center mb-5 pt-4">
                <span class="text-primary fw-bold text-uppercase tracking-wider">Capabilities</span>
                <h2 class="display-5 fw-bold brand-font mb-3 mt-2">Everything you need</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">A complete suite of tools designed specifically for modern procurement teams to move faster.</p>
            </div>
            
            <!-- Category Filters -->
            <div class="d-flex justify-content-center gap-2 mb-5 flex-wrap">
                <button class="btn btn-primary-custom filter-btn active" data-filter="all">All Features</button>
                <button class="btn btn-outline-light filter-btn" data-filter="management">Management</button>
                <button class="btn btn-outline-light filter-btn" data-filter="analytics">Analytics & Reporting</button>
                <button class="btn btn-outline-light filter-btn" data-filter="security">Security</button>
            </div>
            
            <div class="d-grid gap-4" id="featuresGrid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
                <div class="feature-item" data-category="management">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Supplier Management">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-people"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Supplier Management</h5>
                            <p class="text-muted mb-0 small">Onboard, manage, and evaluate your vendors all in one centralized hub.</p>
                        </div>
                    </div>
                </div>
                <div class="feature-item" data-category="management">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Request Tracking">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-card-checklist"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Purchase Requests</h5>
                            <p class="text-muted mb-0 small">Easily submit, approve, and track purchase requests in real-time.</p>
                        </div>
                    </div>
                </div>
                <div class="feature-item" data-category="analytics">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Analytics">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-graph-up"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Vendor Analytics</h5>
                            <p class="text-muted mb-0 small">Make data-driven decisions with detailed supplier performance metrics.</p>
                        </div>
                    </div>
                </div>
                <div class="feature-item" data-category="security">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Security">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-shield-lock"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Secure Auth</h5>
                            <p class="text-muted mb-0 small">Protect your data with industry-leading encrypted authentication.</p>
                        </div>
                    </div>
                </div>
                
                <div class="feature-item" data-category="security">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Roles">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-person-badge"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Role-Based Access</h5>
                            <p class="text-muted mb-0 small">Strict permission controls ensure users only see what they need to.</p>
                        </div>
                    </div>
                </div>
                <div class="feature-item" data-category="management">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1577563908411-50cb98976fea?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Notifications">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-bell"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Real-Time Alerts</h5>
                            <p class="text-muted mb-0 small">Never miss an update with instant alerts for approvals and statuses.</p>
                        </div>
                    </div>
                </div>
                <div class="feature-item" data-category="analytics">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Reports">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-file-earmark-bar-graph"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Advanced Reports</h5>
                            <p class="text-muted mb-0 small">Generate comprehensive financial and operational procurement reports.</p>
                        </div>
                    </div>
                </div>
                <div class="feature-item" data-category="management">
                    <div class="custom-card h-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=500&q=80" class="w-100" style="height: 160px; object-fit: cover;" alt="Knowledge Base">
                        <div class="p-4">
                            <div class="feature-icon mt-n5 position-relative bg-dark border border-secondary shadow"><i class="bi bi-journal-richtext"></i></div>
                            <h5 class="fw-bold mb-3 mt-3">Knowledge Base</h5>
                            <p class="text-muted mb-0 small">Centralize procurement policies and training materials across teams.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 fade-in-up delay-300" style="background: rgba(15, 23, 42, 0.4); position: relative; z-index: 1;">
        <div class="container py-5 border-top border-secondary" style="border-color: var(--glass-border) !important;">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase tracking-wider">Workflow</span>
                <h2 class="display-5 fw-bold brand-font mb-3 mt-2">How It Works</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">Streamlined process from vendor onboarding to final procurement.</p>
            </div>

            <div class="row align-items-center position-relative">
                <div class="col-md-4 text-center mb-4 mb-md-0 position-relative">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2rem; color: white; box-shadow: 0 0 20px rgba(79,70,229,0.5);">
                        1
                    </div>
                    <h4 class="fw-bold">Register</h4>
                    <p class="text-muted">Create your account and setup your organization profile.</p>
                </div>
                <div class="col-md-4 text-center mb-4 mb-md-0 position-relative">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2rem; color: white; box-shadow: 0 0 20px rgba(79,70,229,0.5);">
                        2
                    </div>
                    <h4 class="fw-bold">Onboard Vendors</h4>
                    <p class="text-muted">Invite suppliers and gather their required documentation.</p>
                </div>
                <div class="col-md-4 text-center position-relative">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2rem; color: white; box-shadow: 0 0 20px rgba(79,70,229,0.5);">
                        3
                    </div>
                    <h4 class="fw-bold">Transact</h4>
                    <p class="text-muted">Submit requests, approve quotes, and manage your supply chain.</p>
                </div>
            </div>
            
            <div class="text-center mt-5 pt-4">
                <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5">Get Started Now</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 text-muted" style="background: var(--dark-bg); border-top: 1px solid var(--glass-border); position: relative; z-index: 1;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h4 class="brand-font text-white mb-2"><i class="bi bi-box-seam text-primary me-2"></i>eProcure</h4>
                    <p class="mb-0 small">Next-Gen Supplier Relationship Management</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex justify-content-center justify-content-md-end gap-3 mb-3">
                        <a href="#" class="text-muted text-decoration-none"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-muted text-decoration-none"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-muted text-decoration-none"><i class="bi bi-github"></i></a>
                    </div>
                    <p class="mb-0 small">&copy; {{ date('Y') }} eProcurement SRM. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // Category Filter Logic
            const filterBtns = document.querySelectorAll('.filter-btn');
            const featureItems = document.querySelectorAll('.feature-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => {
                        b.classList.remove('btn-primary-custom', 'active');
                        b.classList.add('btn-outline-light');
                    });
                    
                    // Add active class to clicked button
                    btn.classList.remove('btn-outline-light');
                    btn.classList.add('btn-primary-custom', 'active');

                    const filterValue = btn.getAttribute('data-filter');

                    featureItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                            // Re-trigger animation
                            item.classList.remove('fade-in-up');
                            void item.offsetWidth; // trigger reflow
                            item.classList.add('fade-in-up');
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
