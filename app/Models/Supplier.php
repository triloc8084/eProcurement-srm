<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'category',
        'address',

        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function procurements()
    {
        return $this->hasMany(Procurement::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->procurements()->whereNotNull('customer_rating')->avg('customer_rating');
    }

    public function getRatingCountAttribute()
    {
        return $this->procurements()->whereNotNull('customer_rating')->count();
    }
}

