<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class HomeController extends Controller
{
    public function index()
    {
        // Отримання 8 випадкових книг
        $publications = Publication::with('rating')->inRandomOrder()->limit(8)->get();

        return view('home', compact('publications'));
    }
}
