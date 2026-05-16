@extends('layouts.main')

@section('title', 'Send Notification')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">Compose Alert</h2>
        <p class="text-muted mb-0">Push real-time notifications to users.</p>
    </div>
    <a href="{{ route(Auth::user()->role . '.notifications.index') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-2"></i> Back to History
    </a>

</div>

<div class="row">
    <div class="col-lg-8">
        <div class="custom-card p-4">
            <form action="{{ route(Auth::user()->role . '.notifications.store') }}" method="POST">

                @csrf
                
                <div class="mb-4">
                    <label class="form-label text-muted">Recipient <span class="text-danger">*</span></label>
                    <select name="user_id" class="form-select bg-dark text-white border-secondary @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Select Recipient --</option>
                        <option value="all" class="fw-bold text-primary">📢 Broadcast to All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text text-muted small mt-1">Select "Broadcast" to send this alert to everyone on the platform.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Notification Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control bg-dark text-white border-secondary @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. System Maintenance Update" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Message Body <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control bg-dark text-white border-secondary @error('message') is-invalid @enderror" rows="5" placeholder="Enter the full alert details here..." required>{{ old('message') }}</textarea>
                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <hr class="border-secondary my-4">
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-send me-2"></i> Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
