<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $user = Auth::user();
        
        $activeRequests = Procurement::where('requested_by', $userId)
            ->where('status', 'pending')
            ->count();
            
        $approvedRequests = Procurement::where('requested_by', $userId)
            ->where('status', 'approved')
            ->count();
            
        $rejectedRequests = Procurement::where('requested_by', $userId)
            ->where('status', 'rejected')
            ->count();
            
        $unreadNotifications = $user->customNotifications()->where('is_read', false)->count();
        
        $notifications = $user->customNotifications()->latest()->take(5)->get();
        
        $recentRequests = Procurement::where('requested_by', $userId)
            ->with('supplier')
            ->latest()
            ->take(5)
            ->get();

        // Chart: User Budget Usage (Quarterly for current year)
        $currentYear = Carbon::now()->year;
        $budgetDataRaw = Procurement::where('requested_by', $userId)
            ->whereIn('status', ['approved', 'completed'])
            ->whereYear('created_at', $currentYear)
            ->selectRaw('QUARTER(created_at) as quarter, SUM(budget) as total')
            ->groupBy('quarter')
            ->pluck('total', 'quarter')->toArray();
            
        $budgetData = [
            $budgetDataRaw[1] ?? 0,
            $budgetDataRaw[2] ?? 0,
            $budgetDataRaw[3] ?? 0,
            $budgetDataRaw[4] ?? 0,
        ];

        return view('user.dashboard', compact(
            'activeRequests', 'approvedRequests', 'rejectedRequests', 
            'unreadNotifications', 'recentRequests', 'notifications', 'budgetData'
        ));
    }
}
