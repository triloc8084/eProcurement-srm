<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Procurement;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::where('status', 'active')
            ->withCount(['procurements as rating_count' => function ($q) {
                $q->whereNotNull('customer_rating');
            }])
            ->withAvg(['procurements as average_rating' => function ($q) {
                $q->whereNotNull('customer_rating');
            }], 'customer_rating');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('company_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('address', 'LIKE', "%{$searchTerm}%");
            });
        }

        $suppliers = $query->latest()->paginate(12);
        return view('user.suppliers.index', compact('suppliers'));
    }

    public function show(Supplier $supplier)
    {
        $feedbacks = Procurement::where('supplier_id', $supplier->id)
            ->whereNotNull('customer_rating')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('user.suppliers.show', compact('supplier', 'feedbacks'));
    }
}
