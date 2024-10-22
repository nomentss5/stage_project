<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Candidat;
use App\Models\Cv;
use App\Models\Historique_statu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CandidatController extends Controller
{
    public function insertCandidat(Request $request){

        Validator::make($request->all(), [
            'nom' => 'required',    
            'genre' => 'required',
            'telephone' => 'required',
            'adresse' => 'required',
            'email' => 'required|email',
            'poste_postule' => 'required',
            'nationalite' => 'required',
            'date_postule' => 'required',
            'date_naissance' => 'required',
            'formation_diplome' => 'required',
            'competence' => 'required',
            'experience_pro' => 'required',
            'qualite' => 'required',
            'langue' => 'required|array|min:1',
            // 'centre_interet' => 'required',
        ],[
            'nom.required' => 'le nom est requis',
            'genre.required' => 'le genre est requis',
            'telephone.required' => 'le téléphone est requis',
            'adresse.required' => 'l\'adresse est requise',
            'email.required' => 'l\'email est requis',
            'email.email' => 'l\'email n\'est pas valide',
            'langue.required' => 'choisir au moins une langue',

        ])-> validate();


        // Obtenir la date d'aujourd'hui
        $today = Carbon::today();
        // Formater la date (facultatif)
        $formattedToday = $today->format('Y-m-d');

        $candidat = Candidat::create([ 
            
            'nom' => $request->nom,
            'specialisation' => $request->specialisation,
            'genre' => $request->genre,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'id_poste' => $request->poste_postule,
            'nationalite' => $request->nationalite,
            'date_postule' => $request->date_postule,
            'date_insertion' => $formattedToday,
            'date_naissance' => $request->date_naissance,
            'formation_diplome' => $request->formation_diplome,
            'competence' => $request->competence,
            'experience_pro' => $request->experience_pro,
            'qualite' => $request->qualite,
            'centre_interet' => $request->centre_interet,
            'id_statu' => 1,
            // 'id_cv_path' => null
        ]);

        // Récupérer les valeurs des checkboxes
        $langue = $request->input('langue', []);

        // Boucle pour insérer chaque valeur dans la base de données
        if (!empty($langue)){
            foreach ($langue as $value) {
                DB::table('candidat_langue')->insert([
                    'id_candidat' => $candidat->id,
                    'id_langue' => $value,
                ]);
            }
        }
        
        return redirect()->route('showCandidats');
    }

    public function updateCandidat(Request $request){
        // Trouver le candidat par son ID

        $id = $request->input('id');

        $candidat = Candidat::findOrFail($id);

        $candidat->nom = $request->input('nom');
        $candidat->specialisation = $request->input('specialisation');
        $candidat->genre = $request->input('genre');
        $candidat->telephone = $request->input('telephone');
        $candidat->adresse = $request->input('adresse');
        $candidat->email = $request->input('email');
        $candidat->id_poste = $request->input('poste_postule');
        $candidat->nationalite = $request->input('nationalite');
        $candidat->date_postule = $request->input('date_postule');
        $candidat->date_naissance = $request->input('date_naissance');
        $candidat->formation_diplome = $request->input('formation_diplome');
        $candidat->competence = $request->input('competence');
        $candidat->experience_pro = $request->input('experience_pro');
        $candidat->qualite = $request->input('qualite');
        $candidat->centre_interet = $request->input('centre_interet');

        $candidat->save();        

        
        DB::table('candidat_langue')->where('id_candidat',$id)->delete();

        // Récupérer les valeurs des checkboxes
        $langue = $request->input('langue', []);

        // Boucle pour insérer chaque valeur dans la base de données
        if (!empty($langue)){
            foreach ($langue as $value) {
                DB::table('candidat_langue')->insert([
                    'id_candidat' => $candidat->id,
                    'id_langue' => $value,
                ]);
            }
        }

        return redirect()->route('showCandidats')->with('success', 'Candidat modifié avec succès.');
    }

    public function uploadCv(Request $request){

        Validator::make($request->all(),[
            'nom' => 'required',
            'date_postule' => 'required',
            'cv' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg|max:2048',
        ],[
            'nom.required' => 'le nom est requis',
            'date_postule.required' => 'choisir une date',

        ])-> validate();

        $file = $request->file('cv');

        // prendre timestamp et associer avec le nom de fichier ex:12654_cv.pdf
        $fileName = time().'_'.$file->getClientOriginalName();
        // specifier le repertoire du fichier
        $filePath = $file->storeAs('cvs/', $fileName, 'public');

        $cv_path = CV::create([

            'file_name' => $fileName,
            'file_path' => '/storage/' . $filePath, $filePath,
        ]);

        $candidat = Candidat::create([ 
            'nom' => $request->nom,
            'specialisation' => $request->specialisation,
            'genre' => $request->genre,
            'id_poste' => $request->poste_postule,
            'date_postule' => $request->date_postule,
            'id_statu' => 1,
            'id_cv_path' => $cv_path->id,
        ]);

        // dump("vita ny insertion");
        return redirect()->route('showCandidats');
    }
}