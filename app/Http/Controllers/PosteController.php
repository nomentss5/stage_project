<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PosteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $poste= Poste::all();

        return view('poste.Poste', compact('poste'));
    }

    public function insert_poste(Request $request)
    {

        Validator::make($request->all(), [
            'nom_poste' => 'required',
        ],[
            'nom_poste.required' => 'le nom de poste est requis',
        ])-> validate();

        $nom_poste= $request->input('nom_poste');

        // verifier si nom de poste a inserer n'est pas identique
        $verification = Poste::where('nom', $nom_poste)->first();

        if($verification){
            return back()->with('fail_poste', 'ce poste existe deja');

        }else{
                $poste = Poste::create([
                    'nom' => $nom_poste,
                ]);

            return back()->with('success', 'poste ajouté ');
        }

    }

    public function delete($id)
    {
        $poste = Poste::find($id);

        // verifier que ce poste correspond a un candidat
        $validation = Candidat::where('id_poste', $poste->id)->first();

        // si oui eviter la suppression, si non supprimer
        if($validation != null){

            return back()->with('fail', 'ce poste correspond a un candidat ne peut pas etre supprimé');

        }else{
            $poste->delete();
            return back()->with('success', 'poste supprimé');
            
        }
    }

    public function insert_form(){
        return view('poste.insert_poste');
    }
}
