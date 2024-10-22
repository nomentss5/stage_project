@extends('layoutsClient.app')
@section('contents')

<style>

h5{
 color: black;
 text-align: center
};

</style>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card-body">
        <h5>Liste de question a completer pour votre entretien</h5>
        <br>
        <table class="table table-hover">
            <thead class="thead-dark">
              <tr>
                <th></th>
                <th>Entretien pour Poste</th>
                <th>Option</th> <!-- Bouton de choix pour le candidat -->
              </tr>
            </thead>
            <tbody>
                
                @php $counter = 1; @endphp <!-- Initialisation du compteur -->
                @foreach ($liste as $listes)
                <tr>
                    <td>{{ $counter++ }}</td> <!-- Affichage du numéro du candidat -->
                    <td>{{ $listes->poste}}</td>
                    <td><a href="{{ route('entretien.getQuestion',  ['id_user' => auth()->user()->id, 'id_poste' => $listes->id_poste_question ])}}"><button  class="btn btn-outline-dark">Choisir</button></a></td>
                </tr>
                @endforeach   
            </tbody>
        </table>
        @if($liste->isEmpty())
        <p style="text-align: center; color:black">Veuillez patienter vous allez recevoir bientot les questions...</p>
        @else
        @endif
    </div>
  </div>
</div>

@endsection