<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'requested_by',
        'supplier_id',
        'budget',
        'status',
        'attachment_path',
        'internal_notes',
        'customer_rating',
        'customer_feedback',
        'signed_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function adminStatuses()
    {
        return $this->hasMany(ProcurementStatus::class);
    }

    public function getStatusForAdmin($adminId)
    {
        $adminStatus = $this->adminStatuses()->where('admin_id', $adminId)->first();
        return $adminStatus ? $adminStatus->status : 'pending';
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}


