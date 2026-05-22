<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function exportSuppliers()
    {
        $suppliers = \App\Models\Supplier::where('user_id', Auth::id())->get();
        $csvHeader = "ID,Company Name,Contact Name,Email,Phone,Status,Created At\n";
        $csvData = "";
        foreach($suppliers as $s) {
            $csvData .= "{$s->id},\"{$s->company_name}\",\"{$s->name}\",{$s->email},{$s->phone},{$s->status},{$s->created_at}\n";
        }
        
        return response($csvHeader . $csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="suppliers_report.csv"');
    }

    public function exportProcurements()
    {
        $procurements = \App\Models\Procurement::where('requested_by', Auth::id())->with(['supplier', 'user'])->get();
        $csvHeader = "ID,Title,Requested By,Supplier,Budget,Status,Created At\n";
        $csvData = "";
        foreach($procurements as $p) {
            $user = $p->user ? $p->user->name : 'N/A';
            $supplier = $p->supplier ? $p->supplier->company_name : 'N/A';
            $budget = $p->budget ? $p->budget : 0;
            $csvData .= "{$p->id},\"{$p->title}\",\"{$user}\",\"{$supplier}\",{$budget},{$p->status},{$p->created_at}\n";
        }
        
        return response($csvHeader . $csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="procurements_report.csv"');
    }
}

