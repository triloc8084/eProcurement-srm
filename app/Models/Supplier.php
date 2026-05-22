<?php

namespace App\Models;

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
        if (array_key_exists('average_rating', $this->attributes)) {
            return $this->attributes['average_rating'] !== null ? (float) $this->attributes['average_rating'] : 0.0;
        }
        return (float) ($this->procurements()->whereNotNull('customer_rating')->avg('customer_rating') ?? 0.0);
    }

    public function getRatingCountAttribute()
    {
        if (array_key_exists('rating_count', $this->attributes)) {
            return (int) $this->attributes['rating_count'];
        }
        return (int) $this->procurements()->whereNotNull('customer_rating')->count();
    }
}

