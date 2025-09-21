<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){

        $formations =  Formation::latest()->take(3)->get();
        return view('layouts.index',compact('formations'));
    }

    public function showFormations(){

      $formations = Formation::paginate(9);
       return view('layouts.formation.formation-catalog',compact('formations'));  
    }

     public function ShowOneFormation(Formation $formation){
        
        return view('layouts.formation.formation-detail',compact('formation'));
     }
    

}
