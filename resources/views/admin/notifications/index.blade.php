@extends('layouts.main')

@section('title', 'Notification History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">Sent Notifications</h2>
        <p class="text-muted mb-0">View all alerts previously broadcasted to users.</p>
    </div>
    <a href="{{ route(Auth::user()->role . '.notifications.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-bell-fill me-2"></i> Send New Alert
    </a>

</div>

<div class="custom-card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="background: transparent;">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">Sent Date</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Recipient User ID</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Title</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Message Preview</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notif)
                <tr>
                    <td class="align-middle text-nowrap">{{ $notif->created_at->format('M d, Y h:i A') }}</td>
                    <td class="align-middle">#{{ $notif->user_id }}</td>
                    <td class="align-middle fw-bold">{{ $notif->title }}</td>
                    <td class="align-middle text-truncate" style="max-width: 300px;">{{ $notif->message }}</td>
                    <td class="align-middle">
                        @if($notif->is_read)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">Read</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill">Unread</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">No notifications sent yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
