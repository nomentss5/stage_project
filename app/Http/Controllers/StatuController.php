<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Historique_statu;


class StatuController extends Controller
{
    public function updateStatu(Request $request){
        $selected_statu = $request->input('selected_statu');
        $id_candidat = $request->input('id_candidat');

        // dump($id_statu, $id_candidat);

        $candidat = Candidat::findOrFail($id_candidat);

        $old_statu = $candidat->id_statu;
        $new_statu = $selected_statu;
        
        return $this->historiser_statu($old_statu, $new_statu, $candidat); 
        // $candidat->id_statu = $new_statu;

        // $candidat->save();

        // return redirect()->route('showCandidats')->with('success','Status modifié avec succès.');
    }

    public function historiser_statu($old_statu, $new_statu, $candidat) {

        // id de l'user actullement connectée
        $user_id= auth()->user()->id;

        if($old_statu != $new_statu){
            // historiser d'abord le statu avant update
            $historique = Historique_statu::create([ 
                'id_user' => auth()->user()->id,
                'id_candidat' => $candidat->id,
                'id_statu_avant' => $old_statu,
                'id_statu_apres' => $new_statu,
            ]);

            // update du statu du candidat
            $candidat->id_statu = $new_statu;
            $candidat->save();

            return redirect()->route('showCandidats')->with('success','Status modifié avec succès.');
        }
        
        return redirect()->route('showCandidats')->with('success','Le statu n\'a pas changé.');
    }

    public function delete_historique($id){

        $historique = historique_statu::find($id);

        $historique->delete();

        return redirect()->back();
    }
}