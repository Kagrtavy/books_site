<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class HomeController extends Controller
{
    public function index()
    {
        $publications = Publication::with('rating')->inRandomOrder()->limit(10)->get();

        return view('home', ['publications' => $publications]);
    }
}
