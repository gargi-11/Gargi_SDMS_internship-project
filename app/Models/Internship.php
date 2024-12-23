<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'user_id', 'company', 'position', 'start_date', 'end_date', 'description', 'document_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

