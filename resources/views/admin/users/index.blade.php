@extends('layouts.main')

@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">Users</h2>
        <p class="text-muted mb-0">Manage system administrators and regular users.</p>
    </div>
</div>

<div class="custom-card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="background: transparent;">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">ID</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Name</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Email Address</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Role</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Registered Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="align-middle">#{{ $loop->iteration }}</td>
                    <td class="align-middle fw-bold">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" alt="" width="32" height="32" class="rounded-circle me-3">
                            {{ $user->name }}
                        </div>
                    </td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">
                        @if($user->role === 'admin')
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill">Admin</span>
                        @else
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill">User</span>
                        @endif
                    </td>
                    <td class="align-middle">{{ $user->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
