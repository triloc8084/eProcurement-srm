<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\Supplier;
use Illuminate\Http\Request;

use App\Models\ProcurementStatus;
use App\Models\Notification;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;


class ProcurementController extends Controller
{
    public function index()
    {
        // Admins can see ALL procurements
        $procurements = Procurement::with(['supplier', 'user', 'adminStatuses'])
            ->latest()
            ->paginate(10);
            
        return view('admin.procurements.index', compact('procurements'));
    }

    public function create()
    {
        $suppliers = Supplier::where('user_id', Auth::id())->where('status', 'active')->get();
        return view('admin.procurements.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $validated['requested_by'] = Auth::id();

        $procurement = Procurement::create($validated);

        // Save initial status for this admin
        ProcurementStatus::create([
            'procurement_id' => $procurement->id,
            'admin_id' => Auth::id(),
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.procurements.index')->with('success', 'Purchase Order created successfully.');
    }

    public function edit(Procurement $procurement)
    {
        // Admins can edit/approve any procurement
        $suppliers = Supplier::where('user_id', Auth::id())->where('status', 'active')->get();
        
        // Get the status specific to this admin
        $currentStatus = $procurement->getStatusForAdmin(Auth::id());
        
        return view('admin.procurements.edit', compact('procurement', 'suppliers', 'currentStatus'));
    }

    public function update(Request $request, Procurement $procurement)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'budget' => 'nullable|numeric|min:0',
            'internal_notes' => 'nullable|string',
        ]);

        $oldStatus = $procurement->status;

        // Update the global record (supplier/budget/status/notes)
        $procurement->update([
            'supplier_id' => $validated['supplier_id'],
            'budget' => $validated['budget'],
            'status' => $validated['status'],
            'internal_notes' => $validated['internal_notes'],
        ]);

        // Audit Log
        if ($oldStatus !== $validated['status']) {
            AuditLog::create([
                'procurement_id' => $procurement->id,
                'user_id' => Auth::id(),
                'action' => 'status_change',
                'old_value' => $oldStatus,
                'new_value' => $validated['status'],
                'ip_address' => $request->ip(),
            ]);
        }

        // Notify the Customer
        Notification::create([
            'user_id' => $procurement->requested_by,
            'sender_id' => Auth::id(),
            'title' => 'Order Status Updated',
            'message' => 'Your order "' . $procurement->title . '" has been updated to: ' . ucfirst($validated['status']),
            'is_read' => false,
        ]);

        // Update or Create the status for THIS admin
        ProcurementStatus::updateOrCreate(
            ['procurement_id' => $procurement->id, 'admin_id' => Auth::id()],
            ['status' => $validated['status']]
        );

        return redirect()->route('admin.procurements.index')->with('success', 'Procurement request updated successfully.');
    }

    public function destroy(Procurement $procurement)
    {
        $procurement->delete();
        return redirect()->route('admin.procurements.index')->with('success', 'Procurement deleted successfully.');
    }
}
