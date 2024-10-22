@extends('layoutsClient.app')
@section('contents')

<style>

h5{
 color: black;
};

</style>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card-body">
        <h5 style="text-align: center">Liste fiche de reponse</h5>
        <br>
        <table class="table table-hover">
            <thead class="thead-dark">
              <tr>
                <th></th>
                <th>Fiche pour Poste</th>
                <th>Date</th>
                <th>Option</th> <!-- Bouton de choix pour le candidat -->
              </tr>
            </thead>
            <tbody>
                
                @php $counter = 1; @endphp <!-- Initialisation du compteur -->
                @foreach ($liste as $listes)
                <tr>
                    <td>{{ $counter++ }}</td> <!-- Affichage du numéro du candidat -->
                    <td>{{ $listes->poste}}</td>
                    <td>{{ $listes->date_reponse}}</td>
                    <td><a href="{{ route('entretien.getReponse',  ['id_user' => auth()->user()->id, 'id_poste' => $listes->id_poste ])}}"><button  class="btn btn-outline-dark">Voir</button></a></td>
                </tr>
                @endforeach   
            </tbody>
        </table>
        @if($liste->isEmpty())
        <p style="text-align: center; color:black">Veuillez d'abord repondre au questionnaire.</p>
        @else
        @endif
    </div>
  </div>
</div>

@endsection