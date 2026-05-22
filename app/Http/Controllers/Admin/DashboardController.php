<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\Supplier;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $totalSuppliers = Supplier::where('user_id', $userId)->count();
        $pendingRequests = Procurement::where('status', 'pending')->count();
        $approvedPOs = Procurement::where('status', 'approved')->count();
        $totalSpend = Procurement::whereIn('status', ['approved', 'completed'])->sum('budget');
        
        // Calculate Average Rating for this Supplier's handled requests
        $averageRating = Procurement::where('status', 'completed')
            ->whereNotNull('customer_rating')
            ->avg('customer_rating') ?: 0;

        $recentRequests = Procurement::with('user')->latest()->take(5)->get();


        // Admin Activity Feed (User specific notifications)
        $activities = Notification::where('sender_id', $userId)->with('user')->latest()->take(5)->get();

        // Chart 1: Procurement Spend (Monthly for current year)
        $currentYear = Carbon::now()->year;
        $monthlySpend = Procurement::whereIn('status', ['approved', 'completed'])
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, SUM(budget) as total')
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();


        $monthlySpendData = [];
        $monthsLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySpendData[] = $monthlySpend[$i] ?? 0;
        }

        // Chart 2: Supplier Status Doughnut
        $supplierStatuses = Supplier::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();


        $activeSuppliers = $supplierStatuses['active'] ?? 0;
        $pendingSuppliers = $supplierStatuses['pending'] ?? 0;
        $inactiveSuppliers = $supplierStatuses['inactive'] ?? 0;

        // Chart 3: Spend by Department
        $departmentSpend = Procurement::join('users', 'procurements.requested_by', '=', 'users.id')
            ->whereIn('procurements.status', ['approved', 'completed'])
            ->select('users.department', DB::raw('SUM(procurements.budget) as total'))
            ->groupBy('users.department')
            ->get();
        
        $deptLabels = $departmentSpend->pluck('department')->map(fn($d) => $d ?: 'Unknown')->toArray();
        $deptValues = $departmentSpend->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'totalSuppliers', 'pendingRequests', 'approvedPOs', 'totalSpend', 'recentRequests',
            'activities', 'monthlySpendData', 'monthsLabels', 
            'activeSuppliers', 'pendingSuppliers', 'inactiveSuppliers', 'averageRating',
            'deptLabels', 'deptValues'
        ));


    }
}
