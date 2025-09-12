<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $cards = [
            [
                'title' => 'Produits',
                'value' => '120',
                'percent' => '+10%',
                'percentColor' => 'col-green',
                'img' => 'assets/img/banner/shop.png',
            ],
            [
                'title' => 'Formations',
                'value' => '45',
                'percent' => '-5%',
                'percentColor' => 'col-orange',
                'img' => 'assets/img/banner/formations.png',
            ],
            [
                'title' => 'Quiz',
                'value' => '18',
                'percent' => '+12%',
                'percentColor' => 'col-green',
                'img' => 'assets/img/banner/quizz.png',
            ],
            [
                'title' => 'Paiements',
                'value' => '1 250 000 CFA',
                'percent' => '+42%',
                'percentColor' => 'col-green',
                'img' => 'assets/img/banner/paiements.png',
            ],
        ];
        if ($user->role === "admin") {
            return view('admin.layout.index', compact('cards'));
        } else {
            return redirect()->route("accueil");
        }
    }
}
