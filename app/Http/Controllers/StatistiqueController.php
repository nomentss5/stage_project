<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index(){
        // prendre valeur de mois 
        $mois = DB::table('mois')
                ->get();

        return view ('statistique.showStat', compact('mois'));
    }

    // statistique generale par genre par mois, on doit choisir une annee
    public function parGenre($annee){

        // $Mois = DB::table('v_stat_genre')
        // ->select('mois')
        // ->groupBY('mois')
        // ->get();
        
        $quantite = DB::table('v_stat_genre')
        ->select(DB::raw('SUM(nombre) as nombre'), 'genre', 'annee')
        ->groupBy('genre', 'annee')
        ->where('annee', $annee)
        ->get();

        $homme = DB::table('v_stat_genre')
        ->select('nombre','mois','annee')
        ->where('genre', 'Homme')
        ->where('annee', $annee)
        ->get();

        $femme = DB::table('v_stat_genre')
        ->select('nombre','mois','annee')
        ->where('genre', 'Femme')
        ->where('annee', $annee)
        ->get();

        return response()->json([
            'femmes' => $femme,
            'hommes' => $homme,
            'quantite' => $quantite,
        ]);
    }

    public function parPoste($annee){

        $poste = DB::table('v_stat_poste')
        ->select('nombre','poste_postule','annee')
        ->where('annee', $annee)
        ->get();

        return response()->json([
            'poste' => $poste,
        ]);
    }

    public function parMoisPoste($annee, $mois){

        // si mois existe utiliser la vue contenant le mois sinon utiliser la vue pour stat en une annee
        if (!empty($mois)) {
            $poste = DB::table('v_stat_poste_mois as v')
            ->select('v.nombre as nombre','v.poste_postule as poste_postule','v.annee','m.nom as mois', 'm.numero as numero_mois','v.mois')
            ->join('mois as m', 'm.numero', '=', 'v.mois')
            ->where('v.annee', $annee)
            ->where('mois', $mois)
            ->get();

        }else{
            $poste = DB::table('v_stat_poste')
            ->select('nombre','poste_postule','annee')
            ->where('annee', $annee)
            ->get();
            
        }

        return response()->json([
            'poste' => $poste,
        ]);
    }


    public function parStatut($annee, $mois){

         // si mois existe utiliser la vue contenant le mois sinon utiliser la vue pour stat en une annee
         if (!empty($mois)) {
            $statut = DB::table('v_stat_statut_mois')
            ->where('annee', $annee)
            ->where('numero_mois', $mois)
            ->get();
         }
         else{
            $statut = DB::table('v_stat_statut')
            ->select('nombre','statut','annee')
            ->where('annee', $annee)
            ->get();
         }

        return response()->json([
            'statut' => $statut,
        ]);
    }
}