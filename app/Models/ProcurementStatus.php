<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementStatus extends Model
{
    protected $fillable = [
        'procurement_id',
        'admin_id',
        'status',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

}
