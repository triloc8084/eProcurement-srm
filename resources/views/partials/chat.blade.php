<div class="custom-card p-4 h-100 d-flex flex-column" style="max-height: 600px;">
    <h5 class="fw-bold mb-4 d-flex align-items-center">
        <i class="bi bi-chat-dots text-primary me-2"></i> Order Discussion
    </h5>
    
    <div class="chat-messages flex-grow-1 overflow-auto mb-4 pe-2" style="scrollbar-width: thin;">
        @forelse($procurement->messages as $msg)
            <div class="mb-3 d-flex flex-column {{ $msg->user_id === Auth::id() ? 'align-items-end' : 'align-items-start' }}">
                <div class="p-3 rounded-4 {{ $msg->user_id === Auth::id() ? 'bg-primary text-white rounded-tr-0' : 'bg-secondary bg-opacity-25 rounded-tl-0' }}" style="max-width: 80%;">
                    <small class="d-block fw-bold mb-1 {{ $msg->user_id === Auth::id() ? 'text-white-50' : 'text-primary' }}" style="font-size: 0.7rem;">
                        {{ $msg->user->name }} • {{ $msg->created_at->diffForHumans() }}
                    </small>
                    <p class="mb-0 text-sm">{{ $msg->message }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-chat-left display-4 d-block mb-3 opacity-25"></i>
                <p>No messages yet. Start the conversation!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
        <form action="{{ route('messages.store', $procurement) }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="message" class="form-control bg-dark text-white border-secondary rounded-start-pill px-4" placeholder="Type your message..." required autocomplete="off">
                <button type="submit" class="btn btn-primary-custom rounded-end-pill px-4">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .chat-messages::-webkit-scrollbar { width: 5px; }
    .chat-messages::-webkit-scrollbar-track { background: transparent; }
    .chat-messages::-webkit-scrollbar-thumb { background: var(--glass-border); border-radius: 10px; }
    .rounded-tr-0 { border-top-right-radius: 0 !important; }
    .rounded-tl-0 { border-top-left-radius: 0 !important; }
</style>
