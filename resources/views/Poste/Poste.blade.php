@extends('layoutsAdmin.app')
@section('contents')

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                  {{-- <div class="col-sm-3">  
                      <a href="{{ route('poste.formulaire') }}">   
                    <button type="submit" class="btn btn-outline-primary ">Ajouter</button> 
                    </a>
                </div> --}}
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">Nouveau poste</h4>
                    <form action="{{ route('poste.create')}}" method="GET">
                    <br>
                    @if(session('fail_poste'))
                    <div class="alert alert-danger">
                        {{ session('fail_poste') }}
                    </div>
                    @endif
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nom de poste</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="nom_poste" >
                            </div>
                            <label style="margin-left: 2%">
                                @error('nom_poste')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                              </label>
                          </div>                  
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-primary  " onclick="return validation();">Ajouter</button>
                        
                </div> 
                <h4 class="card-title" style="text-align: center" >Poste existant</h4>
                <br> 
                
                <form action="#" method="GET">
                @if(session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                @endif
                @if(session('fail'))
                  <div class="alert alert-danger">
                      {{ session('fail') }}
                  </div>
                @endif
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr >
                        <th>id</th>
                        <th>Nom</th>
                        <th></th>
                        {{-- <th>Voir Cv</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($poste as $postes)
                          <tr>
                            <td><a href="#">{{ $postes->id }}</a></td>
                            <td>{{ $postes->nom}}</td>
                            <td><a href={{ route('poste.delete', ['id' => $postes->id ]) }} onclick="return confirmation()"> <i class="fas fa-trash" style="color: red"></i></a></td>
                          </tr>
                      @endforeach
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
    <script>
        function validation() {
            return confirm('Êtes-vous sûr de vouloir ajouter un poste ?');
        }

        function confirmation() {
            return confirm('Êtes-vous sûr de vouloir supprimer ?');
        }
    </script>
@endsection
