@extends('layouts.main')

@section('title', 'Settings')

@section('content')
<div class="mb-4">
    <h2 class="brand-font mb-1">System Settings</h2>
    <p class="text-muted mb-0">Manage global configuration for the SRM platform.</p>
</div>

<div class="row">
    <div class="col-12 text-center py-5 mt-5">
        <i class="bi bi-gear display-1 text-muted mb-3 d-block"></i>
        <h3 class="text-muted brand-font">Settings Module Coming Soon</h3>
        <p class="text-muted">Global system configuration will be available in the next release.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary-custom mt-3">Return to Dashboard</a>
    </div>
</div>
@endsection
