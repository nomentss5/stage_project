<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Poste;
use App\Models\Notification;
use App\Models\Notification_recruteur;
use App\Models\Classement;
use App\Models\Questionnaire;
use Carbon\Carbon;
use App\Models\Reponse_questionnaire;
use Illuminate\Support\Facades\DB;

class EntretienController extends Controller
{
    public function liste_user(){
        $user = User::where('level', 1)
        ->get();

        return view('Entretien/liste_candidat', compact('user'));
    }

    public function delete($id){

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'candidat supprimé');
    }

    public function Question_form($id){

        $user = User::where('id',$id)->first();
        $poste =  DB::table('v_questionnaire_dispo')->get();


        return view('Entretien.insertion_question', compact('user','poste'));
    }

    public function insert_questionnaire(Request $request){
        $id_poste_question = $request->input('id_poste_question');

        $id_user = $request->input('id_user');

        // verifier si la question a deja ete envoye ou non
        $verifier = DB::table('user_question')
        ->where('id_user', $id_user)
        ->where('id_poste_question', $id_poste_question)
        ->first();


        // verifier si la question 

        if($verifier!= null){

            return back()->with('fail', 'Questionnaire déja envoyé au candidat');

        }else{
            DB::table('user_question')->insert([
                'id_user' => $id_user,
                'id_poste_question' => $id_poste_question
            ]);

            return back()->with('success', 'Questionnaire envoyé au candidat');
        }

        return back()->with('fail', 'Un probleme est survenu');
    }

    public function getQuestion($id_user, $id_poste){
        $user_question = DB::table('user_question')
        ->where('id_user', $id_user)
        ->where('id_poste_question', $id_poste)
        ->first();

        $verifier_entretien = DB::table('reponse_entretien')
        ->join('questionnaire', 'reponse_entretien.id_question', '=', 'questionnaire.id')
        ->where('reponse_entretien.id_user', $id_user)
        ->where('questionnaire.id_poste', $id_poste)
        ->first();

        // recuperer id_question_poste correspondante au poste du candidat
        if($user_question){

            $result = [];

            if($verifier_entretien){
                session()->forget('success');
                session()->put('entretenu', '');
                return view('ClientAffichage.Question', compact('result'));
            }

            $id_poste_question= $user_question->id_poste_question;

            // recuperer question correspondante au poste du candidat
            $questions = Questionnaire::where('id_poste', $id_poste_question)->get();
            
            $i=0;
            foreach($questions as $question){
                
                $reponse = Reponse_questionnaire::where('id_question', $question->id)->get();

                $j=0;
                if($reponse->isEmpty()){
                        $result[$i][0] = [
                            'id_question' => $question->id,
                            'question' => $question->question,
                            'reponse' => null,
                            'id_reponse' => null,
                            'id_poste' => $id_poste_question,
                        ];
                }else{
                    foreach ($reponse as $reponses) {
                        $result[$i][$j] = [
                            'id_question' => $question->id,
                            'question' => $question->question,
                            'reponse' => $reponses->reponse,
                            'id_reponse' => $reponses->id,
                            'id_poste' => $id_poste_question,
                        ];
                        $j++;
                    }
                }
                $i++;   
            }

            session()->put('success', '');
            return view('ClientAffichage.Question', compact('result'));

        }else{
            $result = [];
            session()->put('fail', '');
            return view('ClientAffichage.Question', compact('result'));
        }
    }

    public function insert_entretien(Request $request){

        // prendre timestamp pour avoir date insertion
        $date = Carbon::now()->toDateString();

        // Valider les champs imbriqués de 'reponse'
        $rules = [];
        $messages = [];

        foreach ($request->input('reponse') as $i => $reponses) {
            foreach ($reponses as $j => $reponse) {
                // Ajouter une règle pour chaque champ "reponse"
                $rules["reponse.$i.$j"] = 'required';
                // Ajouter un message personnalisé pour chaque champ
                $messages["reponse.$i.$j.required"] = "Ce champ est requis";
            }
        }

        // Validation en une seule fois
        $this->validate($request, $rules, $messages);

            $question = $request->input('question'); 
            $reponse = $request->input('reponse');


            for ($i=0; $i<count($question); $i++){

                $reponses = $reponse[$i];

                for ($j=0; $j<count($reponses); $j++){
                    // eviter de prendre les valeur non coche dans input checkbox qui sont par defaut 0 pour (en evitant valeur inconnue de boucle)
                    if($reponse[$i][$j]!= 0){

                        // verifier la reponse contenu dans checkbox sinon textarea
                        if (strpos($reponse[$i][$j], '/') == true) {
                            // La chaîne contient une '/'
                            // separer id et reponse et stocker dans des variables
                            list($idReponse, $reponseTexte) = explode('/', $reponse[$i][$j]);

                            dump($idReponse, $reponseTexte);

                            // insertion de la reponse
                            DB::table('reponse_entretien')->insert([
                                'id_user' => auth()->user()->id,
                                'id_question' => $question[$i],
                                'id_reponse' => $idReponse,
                                'reponse' => $reponseTexte,
                                'created_at' => $date,
                            ]);

                        }else{ 

                            // insertion de la reponse
                            DB::table('reponse_entretien')->insert([
                                'id_user' => auth()->user()->id,
                                'id_question' => $question[$i],
                                // 'id_reponse' => ,
                                'reponse' => $reponse[$i][$j],
                                'created_at' => $date,
                            ]);
                        }
                        // dump("question:".$i ." -> boucle_reponse:".$j ." reponse:".$reponse[$i][$j]);

                    }
                }
            }

            // // ajouter au notification pour informer les recruteurs.
            // $notification = Notification::create([
            //     'id_user' => auth()->user()->id,
            //     'type' => 1,
            // ]);

            $id_user= auth()->user()->id;
            $type = 1;
    
            $this->notification_create($id_user, $type);  // inserer notification dans la table notification et notification_recruteur

            // prendre id_poste
            $id_poste = $request->input('id_poste');
            return redirect()->route('entretien.getQuestion', ['id_user' => auth()->user()->id, 'id_poste' => $id_poste]);
    }

    public function getFiche(Request $request,$id_user, $id_poste){
        $user_classe= $request->input('hidden_field_name');

        // dd($user_classe);


        $question = DB::table('v_entretien')
        ->where('id_user', $id_user)
        ->where('id_poste', $id_poste)
        ->select('id_user','id_question','question','id_poste')
        ->groupBy('id_user','id_question','question','id_poste')
        ->get();

        $result=[];

        $i=0;
        foreach ($question as $questions){
            $id_question= $questions->id_question;

            $reponse = DB::table('v_entretien')
            ->where('id_question',$id_question)
            ->where('id_user', $id_user)
            ->where('id_poste', $id_poste)
            ->select('id_reponse', 'reponse', 'note')
            ->get();

            $j=0;
            foreach ($reponse as $reponses){

            // si user_classe != null -> classe, si user_classe = null -> non classe

                if($user_classe != null){
                    $result[$i][$j] = [
                        'id_user' => $id_user,
                        'id_question' => $id_question,
                        'question' => $questions->question,
                        'reponse' => $reponses->reponse,
                        'id_reponse' => $reponses->id_reponse,
                        'id_poste' => $questions->id_poste,
                        'note' => $reponses->note,
                        // 1 si deja classé
                        'classement' => 1,

                    ];
                }
                else{
                    $result[$i][$j] = [
                        'id_user' => $id_user,
                        'id_question' => $id_question,
                        'question' => $questions->question,
                        'reponse' => $reponses->reponse,
                        'id_reponse' => $reponses->id_reponse,
                        'id_poste' => $questions->id_poste,
                        'note' => $reponses->note,
                        // 0 si non classé
                        'classement' => 0,
                    ];
                }
                $j++;
            }
        $i++;
        }
            return view('Entretien.fiche', compact('result'));

    }

    public function genererClassement(Request $request){

        $question  = $request->input('question');
        $note = $request->input('note');
        $id_user = $request->input('id_user');
        $id_poste = $request->input('id_poste');


        $total_point= 0;

        for($i=0; $i<count($question); $i++){
            $notes= $note[$i];

            for($j=0; $j<count($notes); $j++){
                // dump($note[$i][$j]);

                $total_point = $total_point + $note[$i][$j];
            }
        }

        // insertion dans la table classement
        $classement = Classement::create([
            'id_user' => $id_user,
            'id_poste' => $id_poste,
            'point' => $total_point,
        ]);
        
        return redirect()->route('entretien.getListeReponse', ['id_user' => $classement->id_user]);

    }

    public function getReponse($id_user, $id_poste){
        $question = DB::table('v_entretien')
        ->where('id_user', $id_user)
        ->where('id_poste', $id_poste)
        ->select('id_user','id_question','question','id_poste')
        ->groupBy('id_user','id_question','question','id_poste')
        ->get();

    //    dump($question);

        $result=[];

        $i=0;
        foreach ($question as $questions){
            $id_question= $questions->id_question;

            $reponse = DB::table('v_entretien')
            ->where('id_question',$id_question)
            ->where('id_user', $id_user)
            ->where('id_poste', $id_poste)
            ->select('id_reponse', 'reponse', 'note')
            ->get();

            $j=0;
            foreach ($reponse as $reponses){
                $result[$i][$j] = [
                    'id_user' => $id_user,
                    'id_question' => $id_question,
                    'question' => $questions->question,
                    'reponse' => $reponses->reponse,
                    'id_reponse' => $reponses->id_reponse,
                    'id_poste' => $questions->id_poste,
                    'note' => $reponses->note,
                ];
                $j++;
            }
            
            $i++;
        }
            return view('ClientAffichage.reponse', compact('result'));   
    }

    public function getListe($id_user){

        $liste=  DB::table('v_liste_entretien')
        ->where('id_user',$id_user)
        ->get();

        return view('ClientAffichage.question_liste', compact('liste'));

    }

    public function getListeReponse($id_user){

        $liste=  DB::table('v_liste_reponse_poste')
        ->where('id_user',$id_user)
        ->get();

        return view('ClientAffichage.reponse_liste', compact('liste'));

    }


    public function getListeReponseAdmin($id_user){

        $liste=  DB::table('v_verification_classement')
        ->where('id_user',$id_user)
        ->get();

        return view('Entretien.liste_fiche', compact('liste'));

    }

     // inserer notification dans la table notification et notification_recruteur
    // avoir deux parametre l'id du candidat $id_user et le type de notification $type 0 pour notif nouveau candidat et 1 pour notif completion d'entretient
    public function notification_create($id_user, $type){
        $notification = Notification::create([
            'id_user' => $id_user,
            'type' => $type,
        ]);


        $users = User::where('level', 0)
        ->get();

        foreach ($users as $user) {

            $notification_recruteur = Notification_recruteur::create([
                'id_recruteur' => $user->id,
                'id_notification' => $notification->id,
                // 'is_read' => false,
                // 'is_deleted' => false,
            ]);
        }
    }
}