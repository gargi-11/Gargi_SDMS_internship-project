<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'user_id', 'title', 'provider', 'completion_date', 'description', 'document_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
