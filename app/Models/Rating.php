<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Зв'язок із таблицею publications
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
