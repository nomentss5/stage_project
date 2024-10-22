@extends('layoutsAdmin.app')
@section('contents')

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center" > Classement des candidats apres entretien</h4>
                <br>
                <div class="col-md-6">
                <form action="{{ route('classement.filtre' )}}" method="POST">
                    @csrf
                    <div class="input-group">
                        <select class="custom-select" name="id_poste" onchange="this.form.submit()">
                            <option value="">Choisir un poste</option>
                            @foreach ($postes as $poste)
                                <option value={{ $poste->id }} {{ session('question_poste') == $poste->nom ? 'selected' : '' }} >{{ $poste->nom }}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
                </form>          
                <br> 

                <div class="table-responsive">
                  @if(session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                  @endif

                    @if($classement->isEmpty())
                        <p style="text-align: center; color:black">Aucun classement trouvé.</p>
                    @else
                  
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Poste</th>
                        <th>Point obtenu</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp <!-- Initialisation du compteur -->
                      @foreach ($classement as $classements)
                          <tr>
                            <td>{{ $counter++ }}</td> <!-- Affichage du numéro du candidat -->
                            <td>{{ $classements->nom}}</td>
                            <td>{{ $classements->poste}}</td>
                            <td>{{ $classements->point}} pt</td>
                            <td>{{ $classements->date}}</td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @endif
                </div>
            </div>
          </div>
      </div>
    <div>
      {{-- {{ $candidats->links() }} --}}
    </div>
@endsection