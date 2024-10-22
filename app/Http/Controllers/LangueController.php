<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langue;

class LangueController extends Controller
{

    public function langue_liste(){
        $liste = Langue::all();
        return view('Formulaire.insertion_candidat', compact('liste'));
    }
}
