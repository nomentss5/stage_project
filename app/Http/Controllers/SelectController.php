<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Langue;
use App\Models\Candidat;
use App\Models\Poste;
use App\Models\Cv;

class SelectController extends Controller
{
    // prendre toutes les listes pour afficher dans la formulaire d'insertion
    public function liste_formulaire(){
        $liste = Langue::all();
        $poste = Poste::all();
        return view('Formulaire.insertion_candidat', compact('liste','poste'));
    }

    public function formulaire_importation(){
        $poste = Poste::all();
        return view('Formulaire.insertion_import', compact('poste'));
    }

    // liste
    public function liste_candidat(){
        // $candidats = Candidat::orderBy('id', 'DESC')->paginate(10);

        $candidats = DB::table('v_liste_candidat')
        ->orderBy('date_postule', 'DESC')
        ->paginate(10);
        $statu = DB::table('statut')->get();
        $poste = DB::table('poste')->get();

        return view('Liste.Candidat', compact('candidats','statu','poste'));
    }

    public function liste_modifier($id){
        $liste = Langue::all();

        $candidatLangues = DB::table('candidat_langue')->where('id_candidat', $id)->pluck('id_langue')->toArray();

        $statu_select = DB::table('statut')->get();

        $poste = DB::table('poste')->get();

        // Récupérer le candidat avec l'ID spécifié
        $candidat = Candidat::where('id', $id)->first();

        return view('Formulaire.modifier_candidat', compact('candidat','liste','candidatLangues','statu_select','poste'));
    }

    public function liste_modifier_statu($id, $statu){
        // dump($statu);

        // recuperer statu pour afficher dans input select en tant que selected
        session()->put('statu_candidat', $statu);

        // Récupérer le candidat avec l'ID spécifié
        $candidat = Candidat::where('id', $id)->first();

        // afficher liste des statu dans input select
        $statu_select = DB::table('statut')->get();


        $historique_statu = DB::table('v_historique_statu')
        ->where('id_candidat', $id)
        ->get();

        return view('Formulaire.modifier_statu', compact('statu_select','candidat','historique_statu'));
    }

    public function afficher_cv($id){
        $candidat = Candidat::find($id);

        $langue_candidat= DB::table('v_langue')
            ->where('id_candidat', $id)
            ->get();
        // dd($langue_candidat);

        if($candidat->id_cv_path != null){
            $cv = Cv::find($candidat->id_cv_path);
            $path= $cv->file_path;

            return redirect($path);
        }

        else{
            return view('CvForm.CvForm', compact('candidat', 'langue_candidat'));
        }
    }

    public function recherche(Request $request){

        $recherche_texte= $request->input('recherche_texte');

        $button = $request->input('button');

        if ($button === 'recherche') {

            $candidats = DB::table('v_liste_candidat')
            ->where('nom', 'ILIKE', '%' . $recherche_texte . '%')
            ->orWhere('specialisation', 'ILIKE', '%' . $recherche_texte . '%')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));

        } elseif ($button === 'filtre') {

            return $this->filtrage($request);
        }
    }
    
    public function filtrage($request){
        $ordre= $request->input('ordre');
            $request->session()->put('selected_order', $ordre);

            // dump('$statu && $poste_postule == Tout');
            if($ordre == 'plus recent'){
                // dump('plus recent');
                return $this->ordre_plus_recent($request);

            }elseif($ordre == 'plus ancien'){
                // dump('plus ancien');
                return $this->ordre_plus_ancien($request);
                
            }
    }

    public function ordre_plus_recent($request){
        $statu= $request->input('statu');
        $poste_postule= $request->input('poste_postule');

        if($statu == 'Tout' && $poste_postule == 'Tout'){

            $request->session()->put('selected_statu', $statu);
            $request->session()->put('selected_poste', $poste_postule);

            $candidats = DB::table('v_liste_candidat')
            ->orderBy('date_postule','DESC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paoginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }
        
        if($statu != 'Tout' && $poste_postule != 'Tout'){

            $request->session()->put('selected_statu', $statu);
            $request->session()->put('selected_poste', $poste_postule);

            // dump('$statu != Tout && $poste_postule != Tout');
            $candidats = DB::table('v_liste_candidat')
            ->where('nom_statu', $statu)
            ->where('poste_postule', $poste_postule)
            ->orderBy('date_postule','DESC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paoginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();
            
            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }
        
        if($statu != 'Tout' && $poste_postule =='Tout' ){
            // dump('$statu != Tout && $poste_postule == Tout');

            // Supprimer la session spécifique
            session()->forget('selected_poste');
            // mettre selection dans session pour l'affichage dans input select
            $request->session()->put('selected_statu', $statu);

            $candidats = DB::table('v_liste_candidat')
            ->where('nom_statu', $statu)
            ->orderBy('date_postule','DESC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paoginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }

        if($statu == 'Tout' && $poste_postule !='Tout' ){
            // dump('$statu == Tout && $poste_postule != Tout');

            // Supprimer la session spécifique
            session()->forget('selected_statu');
            // Stocker la valeur select  dans la session pour selected
            $request->session()->put('selected_poste', $poste_postule);

            $candidats = DB::table('v_liste_candidat')
            ->where('poste_postule', $poste_postule)
            ->orderBy('date_postule','DESC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paoginations
            $candidats->appends($request->all());


            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }

        return null;
    }

    public function ordre_plus_ancien($request){
        $statu= $request->input('statu');
        $poste_postule= $request->input('poste_postule');
        

        if($statu == 'Tout' && $poste_postule == 'Tout'){

            $request->session()->put('selected_statu', $statu);
            $request->session()->put('selected_poste', $poste_postule);

            $candidats = DB::table('v_liste_candidat')
            ->orderBy('date_postule','ASC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paoginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }
        
        if($statu != 'Tout' && $poste_postule != 'Tout'){

            $request->session()->put('selected_statu', $statu);
            $request->session()->put('selected_poste', $poste_postule);

            // dump('$statu != Tout && $poste_postule != Tout');
            $candidats = DB::table('v_liste_candidat')
            ->where('nom_statu', $statu)
            ->where('poste_postule', $poste_postule)
            ->orderBy('date_postule','ASC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }
        
        if($statu != 'Tout' && $poste_postule =='Tout' ){
            // dump('$statu != Tout && $poste_postule == Tout');

            // Supprimer la session spécifique
            session()->forget('selected_poste');
            // mettre selection dans session pour l'affichage dans input select
            $request->session()->put('selected_statu', $statu);

            $candidats = DB::table('v_liste_candidat')
            ->where('nom_statu', $statu)
            ->orderBy('date_postule','ASC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }

        if($statu == 'Tout' && $poste_postule !='Tout' ){
            // dump('$statu == Tout && $poste_postule != Tout');

            // Supprimer la session spécifique
            session()->forget('selected_statu');
            // Stocker la valeur select  dans la session pour selected
            $request->session()->put('selected_poste', $poste_postule);

            $candidats = DB::table('v_liste_candidat')
            ->where('poste_postule', $poste_postule)
            ->orderBy('date_postule','ASC')
            ->paginate(10);

            // envoie la liste de recherche dans tout les paginations
            $candidats->appends($request->all());

            $statu = DB::table('statut')->get();
            $poste = DB::table('poste')->get();

            return view('Liste.Candidat', compact('candidats','statu','poste'));
        }
        return null;
    }
}