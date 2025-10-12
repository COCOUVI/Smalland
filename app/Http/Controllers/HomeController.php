<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class HomeController extends Controller
{
    public function index()
    {
        $latestPublications = Publication::with('category')
            ->where('status', 'publish') // optionnel
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('layouts.index', compact('latestPublications'));
    }
}
