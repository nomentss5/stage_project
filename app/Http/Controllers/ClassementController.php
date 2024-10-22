<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use Illuminate\Support\Facades\DB;


class ClassementController extends Controller
{
    public function index(){
        
        $classement = DB::table('v_classement')
        ->orderBy('point', 'desc')
        ->get();

        $postes =  Poste::All();

        return view('Entretien.classement', compact('classement','postes'));


    }

    public function classement_poste(Request $request){

        $id_poste = $request->input('id_poste');

        $classement = DB::table('v_classement')
        ->where('id_poste', $id_poste)
        ->orderBy('point', 'desc')
        ->get();

        $postes = Poste::All();

        return view('Entretien.classement', compact('classement','postes'));


    }
}