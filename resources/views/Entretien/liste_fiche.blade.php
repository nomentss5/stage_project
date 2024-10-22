@extends('layoutsAdmin.app')
@section('contents')

<style>

label{
  width: 50%;
  height: 100%;
  text-align: center

}

td{
  text-align: center;

}

th{
  text-align: center;


}
</style>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
    <div class="card-body">
        <h5 style="text-align: center">Liste fiche de reponse du candidat</h5>
        <br>
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>Reponse pour Poste</th>
                <th>Date reponse</th>
                <th>Etat du classement</th>
                <th>option</th> <!-- Bouton de choix pour le candidat -->
              </tr>
            </thead>
            <tbody>
                @foreach ($liste as $listes)
                <input type="hidden" name="user_classe" value={{$listes->user_classe}} >
                <tr>
                    <td>{{ $listes->poste}}</td>
                    <td>{{ $listes->date_reponse}}</td>
                    @if($listes->user_classe != null)
                    <td><label class="badge badge-success">classé</label></td>
                    @else
                    <td><label class="badge badge-danger">non classé</label></td>
                    @endif
                    <td><a href="{{ route('entretien.getFiche',  ['id_user' => $listes->id_user, 'id_poste' => $listes->id_poste ])}}?hidden_field_name= {{$listes->user_classe}} "><button  class="btn btn-outline-dark">Voir</button></a></td>
                </tr>
                @endforeach   
            </tbody>
        </table>
        @if($liste->isEmpty())
        <p style="text-align: center; color:black">en attente de reponse.</p>
        @else
        @endif
    </div>
    </div>
  </div>
</div>

@endsection