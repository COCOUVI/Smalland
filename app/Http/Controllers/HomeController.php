<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Product;

class HomeController extends Controller
{
   

    public function index()
    {
        $latestPublications = Publication::with('category')
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $produitsPopulaires = Product::where('qte', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('layouts.index', compact('latestPublications', 'produitsPopulaires'));
    }

}
