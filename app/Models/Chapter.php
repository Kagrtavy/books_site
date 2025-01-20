<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'text', 'publication_id'];

    public $timestamps = false;

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
