<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('sender_id', Auth::id())->latest()->paginate(15);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string', // can be 'all' or a numeric ID
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $senderId = Auth::id();

        if ($validated['user_id'] === 'all') {
            $users = User::all();
            $notifications = [];
            foreach ($users as $user) {
                $notifications[] = [
                    'user_id' => $user->id,
                    'sender_id' => $senderId,
                    'title' => $validated['title'],
                    'message' => $validated['message'],
                    'is_read' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Notification::insert($notifications);
        } else {
            Notification::create([
                'user_id' => $validated['user_id'],
                'sender_id' => $senderId,
                'title' => $validated['title'],
                'message' => $validated['message'],
                'is_read' => false,
            ]);
        }


        return redirect()->route('admin.notifications.index')->with('success', 'Notification(s) sent successfully.');
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

