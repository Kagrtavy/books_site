<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class HomeController extends Controller
{

    /**
     * shows page with 10 random works
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $publications = Publication::with('rating')->inRandomOrder()->limit(10)->get();

        return view('home', [
            'publications' => $publications,
            'title' => 'Home',
        ]);
    }
}
