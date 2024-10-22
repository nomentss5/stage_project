@extends('layoutsAdmin.app')
@section('contents')

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center" >Liste des Candidats en cours d'entretien</h4>
                                   
                  <form action="#" method="GET">
                <br> 
                <div class="col-md-12">
                    
                  </form>
                </div>
                <div class="table-responsive">
                  @if(session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                  @endif
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Nom</th>
                        <th>E-Mail</th>
                        <th>Date d'entree</th>
                        <th>Option</th>
                        <th>FIche candidat</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($user as $users)
                          <tr>
                            <td>{{ $users->name }}</td>
                            <td>{{ $users->identifier}}</td>
                            <td>{{ $users->created_at}}</td>
                            <td><a href={{route('entretien.envoyer', ['id' => $users->id]) }}><button class="btn btn-outline-dark">Donner question</button></a></a></td>
                            <td><a href={{route('entretien.getListeReponse', ['id_user' => $users->id]) }}  ><button style="width: 75%" class="btn btn-outline-dark">Voir</button></a></td>
                            <td><a href={{route('entretien.delete', ['id' => $users->id]) }} onclick="return confirmation()"><i class="fas fa-trash" style="color: red"></i></a></td>
                            {{-- <td><a href={{route('candidat.modifier', ['id' => $candidat->id]) }}><i class="fas fa-trash"></i></a></td> --}}
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
      </div>
    <div>
      {{-- {{ $candidats->links() }} --}}
    </div>
    <script>
      function confirmation() {
          return confirm('Êtes-vous sûr de vouloir supprimer ?');
      }
  </script>
@endsection