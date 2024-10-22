<?php
namespace App\Http\Controllers;

use App\Models\SuggestionMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SuggestionMessageController extends Controller
{
    public function index(){

        $suggestion_message = SuggestionMessage::all();
        
        return view('emails.suggestion_message', compact('suggestion_message' ));
        
    }

    public function update_form($id){

        // Récupérer la suggestion avec l'ID spécifié
        $suggestion_message = SuggestionMessage::where('id', $id)->first();
        // return redirect()->back()->with('modifier', $suggestion_message);
        return view('Formulaire.modifier_suggestion', compact('suggestion_message'));


        // return view('Formulaire.modifier_candidat', compact('candidat','liste','candidatLangues','statu_select'));
    }

    public function delete_suggestion($id){

        $suggestion_message = SuggestionMessage::find($id);

        $suggestion_message->delete();

        return redirect()->back();
    }

    public function update_suggestion(Request $request){

        $id = $request->input('id');

        $suggestion_message = SuggestionMessage::findOrFail($id);

        $suggestion_message->nom = $request->input('nom_suggestion');
        $suggestion_message->message = $request->input('message');
        $suggestion_message->save();


        return redirect()->route('suggestion.index')->with('success', 'suggestion modifié avec succès.');
    }

    public function insert_suggestion(Request $request){

        Validator::make($request->all(), [
            'nom_suggestion' => 'required',
            'message' => 'required',
        ],[
            'nom_suggestion.required' => 'le nom de suggestion est requis',
            'message.required' => 'le message est requis',

        ])-> validate();


        $suggestion_message = SuggestionMessage::create([
            'nom' => $request->input('nom_suggestion'),
            'message' => $request->input('message'),

        ]);

        return redirect()->back()->with('success', 'suggestion creé avec succès.');
    }
}