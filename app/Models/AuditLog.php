<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'procurement_id',
        'user_id',
        'action',
        'old_value',
        'new_value',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }
}

