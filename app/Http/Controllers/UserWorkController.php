<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Publication;

class UserWorkController extends Controller
{
    public function index()
    {
        $works = Publication::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.user-works', compact('works'));
    }
}
