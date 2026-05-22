<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\Supplier;
use App\Models\Notification;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RequestController extends Controller
{
    public function index()
    {
        $requests = Procurement::where('requested_by', Auth::id())
            ->with('supplier')
            ->latest()
            ->paginate(10);
            
        return view('user.requests.index', compact('requests'));
    }

    public function create(Request $request)
    {
        $suppliers = Supplier::where('status', 'active')->get();
        $reorder = null;
        if ($request->has('reorder_id')) {
            $reorder = Procurement::where('requested_by', Auth::id())->find($request->reorder_id);
        }
        return view('user.requests.create', compact('suppliers', 'reorder'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'budget' => 'nullable|numeric|min:0',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        $validated['requested_by'] = Auth::id();
        $validated['status'] = 'pending';

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('procurements', 'public');
            $validated['attachment_path'] = $path;
        }

        $proc = Procurement::create($validated);

        // Notify all Suppliers (Admins)
        $suppliers = User::where('role', 'admin')->get();
        foreach ($suppliers as $supplier) {
            Notification::create([
                'user_id' => $supplier->id,
                'sender_id' => Auth::id(),
                'title' => 'New Service Request',
                'message' => 'A new request "' . $proc->title . '" has been submitted for review.',
                'is_read' => false,
            ]);
        }



        return redirect()->route('user.requests.index')->with('success', 'Procurement request submitted successfully.');
    }

    public function show(Procurement $request)
    {
        if ($request->requested_by !== Auth::id()) {
            abort(403);
        }
        return view('user.requests.show', compact('request'));
    }
    public function rate(Request $request, Procurement $proc)
    {
        if ($proc->requested_by !== Auth::id()) {

            abort(403);
        }

        if ($proc->status !== 'completed') {
            return back()->with('error', 'You can only rate completed requests.');
        }

        $validated = $request->validate([
            'customer_rating' => 'required|integer|min:1|max:5',
            'customer_feedback' => 'nullable|string',
        ]);

        $proc->update($validated);

        // Notify all Suppliers (Admins) who have interacted with this or just broadcast
        // For simplicity, we notify the system admins
        $suppliers = User::where('role', 'admin')->get();
        foreach ($suppliers as $supplier) {
            Notification::create([
                'user_id' => $supplier->id,
                'sender_id' => Auth::id(),
                'title' => 'New Customer Feedback',
                'message' => 'A customer has left a ' . $validated['customer_rating'] . '-star rating for "' . $proc->title . '".',
                'is_read' => false,
            ]);
        }



        return back()->with('success', 'Thank you for your feedback!');
    }

    public function sign(Request $request, Procurement $procurement)
    {
        if ($procurement->requested_by !== Auth::id()) {
            abort(403);
        }

        if ($procurement->status !== 'approved') {
            return back()->with('error', 'You can only sign approved requests.');
        }

        $procurement->update([
            'signed_at' => now(),
            'status' => 'completed'
        ]);

        // Audit Log
        AuditLog::create([
            'procurement_id' => $procurement->id,
            'user_id' => Auth::id(),
            'action' => 'digital_signature',
            'old_value' => 'approved',
            'new_value' => 'completed',
            'ip_address' => $request->ip(),
        ]);


        return back()->with('success', 'Request digitally signed and completed successfully!');
    }
}


