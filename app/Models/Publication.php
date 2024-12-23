<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'user_id', 'title', 'journal', 'publication_date', 'abstract', 'document_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

