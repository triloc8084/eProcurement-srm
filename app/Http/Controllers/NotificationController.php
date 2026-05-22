<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->customNotifications()->latest()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        
        return back()->with('success', 'Notification marked as read.');
    }

    public function poll()
    {
        $userId = Auth::id();
        $unreadCount = Notification::where('user_id', $userId)->where('is_read', false)->count();
        $latest = Notification::where('user_id', $userId)->where('is_read', false)->latest()->first();

        return response()->json([
            'unread_count' => $unreadCount,
            'latest' => $latest
        ]);
    }
}

