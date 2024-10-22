<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use App\Models\Questionnaire;
use App\Models\Reponse_questionnaire;


class QuestionController extends Controller
{
    public function formulaire(){
        $postes = Poste::All();

        return view('Questionnaire.formulaire_creation', compact('postes'));
         
    }

    public function liste(){
        $postes = Poste::All();

        return view('Questionnaire.liste_questionnaire', compact('postes'));  

    }

    public function insert(Request $request){
        $id_poste = $request->input('poste');
        $maxCounter = $request->input('maxCounter');

        // boucle question
        for ($i = 1; $i <= $maxCounter; $i++) {

            $question = $request->input("question_$i");

            // inserer question dans table questionnaire 
            $question_model = Questionnaire::create([
                'id_poste' => $id_poste,
                'question' => $question,
                // 'type' => $request->nom,
            ]);

            // dump($question);

            $reponses = $request->input("reponse_$i");
            $notes = $request->input("note_$i");

            if ($reponses && $notes) {
                // Traiter les réponses ici
                foreach ($reponses as $index => $reponse) {
                    $note = $notes[$index];

                    // inserer reponse et note dans table reponse_questionnaire
                    $reponse_questionnaire = Reponse_questionnaire::create([
                        'id_question' => $question_model->id,
                        'reponse' => $reponse,
                        'note' => $note,
                    ]);

                    // dump("reponse du question $i : " ,$reponse);
                    // dump("note $i : " ,$note);
                }
            }
        }
        return redirect()->route('question.liste');
    }

    public function test(){
        $question = Questionnaire::All();
        // done

        // Initialiser le tableau à deux dimensions
        $result = [];

        $i=0;
        foreach ($question as $questions) {

            $reponse = Reponse_questionnaire::where('id_question', $questions->id)->get();
            // done

            $j=0;
            if($reponse->isEmpty()){
                    $result[$i][0] = [
                        'id_question' => $questions->id,
                        'question' => $questions->question,
                        'reponse' => null,
                        'note' => null,
                    ];
            }else{
                foreach ($reponse as $reponses) {
                    $result[$i][$j] = [
                        'id_question' => $questions->id,
                        'question' => $questions->question,
                        'reponse' => $reponses->reponse,
                        'note' => $reponses->note,
                    ];
                    $j++;
                }
            }
            $i++;   
        }

        $postes = Poste::All();
        return view('Questionnaire.liste_questionnaire', compact('result','postes'));  
    }

    public function formulaire_modification($id){
        $questions = Questionnaire::where('id', $id)->first();

        // prendre poste correspondant a la question
        $poste_correspondant = Poste::where('id', $questions->id_poste)->first();
        // recuperer poste correspondant pour afficher dans input select en tant que selected
        session()->put('question_poste', $poste_correspondant->nom);

        $postes= Poste::All();

        $reponse = Reponse_questionnaire::where('id_question', $questions->id)->get();

        // si reponse n'existe pas
        if($reponse->isEmpty()){
            // Créer une session avec une clé et une valeur vide
            session(['session_reponse' => false]);

        }else{
            session(['session_reponse' => true]);
        }

        return view('Questionnaire.formulaire_modification', compact('questions','postes','reponse'));

    }

    public function delete($id){
        $question = Questionnaire::find($id);
        $reponse = Reponse_questionnaire::where('id_question', $question->id)->get();

        foreach ($reponse as $reponses){
            
            $reponses->delete();
        }
        
        $question->delete();
        
        return redirect()->back();
    }

    public function update(Request $request){

        $maxCounter = $request->input('maxCounter');
        $id_poste = $request->input('poste');

        $id_question= $request->input('id_question');
        $id_reponse= $request->input('id_reponse');

        // mettre a jour question 
        $question = Questionnaire::findOrFail($id_question);
        $question->id_poste = $id_poste;
        $question->question = $request->input('question');
        $question->save();


        // si il y a ajout de reponse 
        for ($i = 1; $i < $maxCounter; $i++) {
            $reponse_questionnaire = Reponse_questionnaire::create([
                'id_question' => $id_question,
                'reponse' => $request->input("new_reponse_$i"),
                'note' => $request->input("new_note_$i")
            ]);
        }

        // verifier la taille de la boucle dans blade
        $boucle = $request->input('boucle');

        if($boucle){
            foreach ($boucle as $i => $boucles){
                $reponse_input = $request->input('reponse_'.$i);
                $note = $request->input('note_'.$i);
                $id_reponse = $request->input('id_reponse_'.$i);

                // mettre a jour reponse
                $reponse = Reponse_questionnaire::findOrFail($id_reponse);
                $reponse->reponse = $reponse_input;
                $reponse->note = $note; 
                $reponse->save();

                // dump($reponse, $id_reponse, $note);
            }
        }

        return redirect()->back();
    }

    // pour trouver les questions par postes
    public function tri_question(Request $request){

        $id_poste= $request->input('poste');

        if($id_poste != 0){
            $question = Questionnaire::where('id_poste', $id_poste)->get();
            
            // pour prendre nom de poste 
            $question_poste = Poste::where('id', $id_poste)->first();
            $request->session()->put('question_poste', $question_poste->nom);
        }
        else{
            $question = Questionnaire::All();
            $request->session()->put('question_poste', 'Tout');
        }
        // done

        // Initialiser le tableau à deux dimensions
        $result = [];

        $i=0;
        foreach ($question as $questions) {

            $reponse = Reponse_questionnaire::where('id_question', $questions->id)->get();
            // done

            $j=0;
            if($reponse->isEmpty()){
                    $result[$i][0] = [
                        'id_question' => $questions->id,
                        'question' => $questions->question,
                        'reponse' => null,
                        'note' => null,
                    ];
            }else{
                foreach ($reponse as $reponses) {
                    $result[$i][$j] = [
                        'id_question' => $questions->id,
                        'question' => $questions->question,
                        'reponse' => $reponses->reponse,
                        'note' => $reponses->note,
                    ];
                    $j++;
                }
            }
            $i++;   
        }

        $postes = Poste::All();
        return view('Questionnaire.liste_questionnaire', compact('result','postes'));

    }
}