@extends('layouts.main')

@section('title', 'My Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">All Notifications</h2>
        <p class="text-muted mb-0">Stay updated with your procurement alerts.</p>
    </div>
</div>

<div class="custom-card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="background: transparent;">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">#</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Date</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Title</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Message</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Status</th>
                    <th class="text-muted fw-normal border-bottom border-secondary text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notif)
                <tr>
                    <td class="align-middle text-muted">{{ $loop->iteration + ($notifications->currentPage() - 1) * $notifications->perPage() }}</td>
                    <td class="align-middle text-nowrap">{{ $notif->created_at->format('M d, Y h:i A') }}</td>
                    <td class="align-middle fw-bold text-white">{{ $notif->title }}</td>
                    <td class="align-middle">{{ $notif->message }}</td>
                    <td class="align-middle">
                        @if($notif->is_read)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">Read</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill">Unread</span>
                        @endif
                    </td>
                    <td class="align-middle text-end">
                        @if(!$notif->is_read)
                            <a href="{{ route('notifications.read', $notif->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                Mark as Read
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">You have no notifications yet.</td>
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
