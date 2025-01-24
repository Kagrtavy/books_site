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
        'status', 'size', 'description', 'created_at'
    ];

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'publication_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_publication');
    }
    public function source()
    {
        return $this->belongsTo(Source::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
