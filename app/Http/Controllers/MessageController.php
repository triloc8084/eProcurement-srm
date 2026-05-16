<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Procurement;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, Procurement $procurement)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'procurement_id' => $procurement->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        // Notify the other party
        $recipientId = (Auth::user()->role === 'admin') 
            ? $procurement->requested_by 
            : User::where('role', 'admin')->first()->id; // Simplification: notify admin

        Notification::create([
            'user_id' => $recipientId,
            'sender_id' => Auth::id(),
            'title' => 'New Message on Order #' . $procurement->id,
            'message' => 'A new message has been posted regarding "' . $procurement->title . '".',
            'is_read' => false,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }
}

