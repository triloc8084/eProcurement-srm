<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    protected $fillable = [
        'title',
        'content',
        'document_path',
        'created_by',
    ];
}
