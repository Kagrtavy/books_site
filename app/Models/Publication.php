<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'photo', 'user_id', 'type', 'authorship',
        'author', 'work_link', 'source_id', 'rating_id',
        'status', 'size', 'description'
    ];

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
